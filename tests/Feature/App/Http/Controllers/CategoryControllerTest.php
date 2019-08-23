<?php

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    /** @var TestResponse */
    protected $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = $this->json('GET','/api/categories');
    }

    public function testStatus()
    {
        $this->response->assertStatus(200);
    }

    public function testStructure()
    {
        $this->response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'parent_id',
                    'title',
                    'content',
                    'position',
                    'created',
                    'children',
                ]
            ]
        ]);

    }
}
