<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        /** @var Article $article */
        $article = factory(Article::class)->create();
        $result = $article->isLikedBy(null);
        $this->assertFalse($result);
    }

    public function testIsLikedByTheUser()
    {
        /** @var Article $article */
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        // 多対多のリレーションでは、attachメソッドが使用できる
        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    public function testIsLikedByAnother()
    {
        /** @var Article $article */
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
