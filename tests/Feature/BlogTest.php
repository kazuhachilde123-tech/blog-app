<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_lists_posts(): void
    {
        Post::factory()->create(['title' => 'Hello World']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Hello World');
    }
}
