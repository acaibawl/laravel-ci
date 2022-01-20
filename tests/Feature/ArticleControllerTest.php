<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('articles.index');
    }

    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));
        $response->assertRedirect(route('login'));
    }

    public function testAuthCreate()
    {
        $user = factory(User::class)->create();
        $resonse = $this->actingAs($user)->get(route('articles.create'));
        $resonse->assertStatus(200)->assertViewIs('articles.create');
    }
}
