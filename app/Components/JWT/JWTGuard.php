<?php

namespace App\Components\JWT;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Traits\Macroable;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
use Illuminate\Contracts\Auth\UserProvider;

class JWTGuard implements Guard
{
    use GuardHelpers, Macroable {
        __call as macroCall;
    }

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    protected $key;

    /**
     * Instantiate the class.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider $provider
     * @param  \Illuminate\Http\Request $request
     *
     * @param string $key
     */
    public function __construct(UserProvider $provider, Request $request, $key = 'token')
    {
        $this->key = $key;
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        try {
            $token = (new Parser())->parse($this->getTokenForRequest());

            $data = new ValidationData();
            $data->setIssuer($this->request->getHost());
            $data->setAudience($this->request->getHost());
            $data->setSubject($token->getClaim('sub'));

            if (! $token->verify(new Sha256(), $this->key) || ! $token->validate($data)) {
                return null;
            }

            return $this->user = $this->provider->retrieveById($token->getClaim('sub'));
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * Create a token for a user.
     *
     * @param Authenticatable $user
     *
     * @param null $minutesExpiresIn
     * @return string
     */
    public function login(Authenticatable $user, $minutesExpiresIn = null)
    {
        $builder = (new Builder())
            ->setId(str_random())
            ->setIssuer($this->request->getHost())
            ->setAudience($this->request->getHost())
            ->setSubject($user->getKey());

        if ($minutesExpiresIn)
        {
            $builder->setExpiration(time() + ($minutesExpiresIn * 60));
        }

        return (string) $builder->sign(new Sha256, $this->key)->getToken();
    }

    public function expiresIn(string $token)
    {
        $token = (new Parser())->parse($token);

        $data = new ValidationData();
        $data->setIssuer($this->request->getHost());
        $data->setAudience($this->request->getHost());
        $data->setSubject($token->getClaim('sub'));

        if (! $token->verify(new Sha256(), $this->key) || ! $token->validate($data)) {
            return null;
        }

        if ($token->hasClaim('exp') && is_numeric($token->getClaim('exp')))
            return $token->getClaim('exp') - time();

        return null;
    }

    /**
     * Get the token for the current request.
     *
     * @return string
     */
    public function getTokenForRequest()
    {
        $token = $this->request->query($this->key);

        if (empty($token)) {
            $token = $this->request->input($this->key);
        }

        if (empty($token)) {
            $token = $this->request->bearerToken();
        }

        if (empty($token)) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        if (empty($credentials['id'])) {
            return false;
        }

        if ($this->provider->retrieveById($credentials['id'])) {
            return true;
        }

        return false;
    }

    /**
     * Attempt to authenticate the user using the given credentials and return the token.
     *
     * @param  array  $credentials
     * @param  bool  $login
     *
     * @return bool|string
     */
    public function attempt(array $credentials = [], $login = true, $minutesExpiresIn = null)
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {
            return $login ? $this->login($user, $minutesExpiresIn) : true;
        }

        return false;
    }

    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     *
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        return $user !== null && $this->provider->validateCredentials($user, $credentials);
    }
}
