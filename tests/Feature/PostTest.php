<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_index(): void
    {
        Post::factory(5)->create();
        $response = $this->get('/api/posts');
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) => 
                $json->first(fn (AssertableJson $json) => 
                    $json
                        ->whereType('post_id', 'integer')
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
        $post = Post::factory()->create();
        $response = $this->get("/api/posts/$post->id");
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->whereAllType([
                        'post_id' => 'integer',
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
                'post_id' => 1,
                'author' => 'Joe Bidden',
                'content' => 'hello there'
            ]);
    }

    public function test_update(){
        $post = Post::factory()->create();
        $response = $this->putJson('/api/posts',[
            'post_id' => $post->id,
            'author' => 'Donald Trump',
            'content' => 'Wassup my dawg'
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'post_id' => 1,
                'author' => 'Donald Trump',
                'content' => 'Wassup my dawg'
            ]);
    }

    public function test_destroy(){
        $post = Post::factory()->create();
        $response = $this->deleteJson("api/posts/$post->id");
        $response->assertStatus(204);
    }
}
