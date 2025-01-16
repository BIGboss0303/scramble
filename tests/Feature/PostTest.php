<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->first(fn (AssertableJson $json) => 
                    $json
                        ->whereType('id', 'integer')
                        ->whereAllType([
                            'author' => 'string',
                            'content' => 'string',
                            'last_updated' => 'string'
                        ])
                        ->etc()

                )
            );
    }
    public function test_show(): void
    {
        $response = $this->get('/api/posts/1');
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->whereAllType([
                        'id' => 'integer',
                        'author' => 'string',
                        'content' => 'string',
                        'last_updated' => 'string'
                    ])
        );
    }
    public function test_store(): void
    {
        $response = $this->postJson('/api/posts', [
            'author' => 'Joe Bidden',
            'content' => 'hello there'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'id' => 11,
                'author' => 'Joe Bidden',
                'content' => 'hello there'
            ]);
    }

    public function test_update(){
        $response = $this->putJson('/api/posts',[
            'id' => 11,
            'author' => 'Donald Trump',
            'content' => 'Wassup my dawg'
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => 11,
                'author' => 'Donald Trump',
                'content' => 'Wassup my dawg'
            ]);
    }

    public function test_destroy(){
        $response = $this->deleteJson('api/posts',[
            'id' => 11,
        ]);
        $response->assertStatus(204);
    }
}
