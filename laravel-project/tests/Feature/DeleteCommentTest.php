<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
    private Comment $comment;
    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var Comment $comment */
        $comment = Comment::factory()->create();

        $this->comment = $comment;
        $this->post = $comment->post;
    }

    public function testDeleteArticleComment(): void
    {
        $this->actingAs($this->comment->user)
            ->deleteJson("/comments/{$this->comment->id}")
            ->assertOk();

        $this->assertModelMissing($this->comment);
    }

    public function testDeleteCommentOfNonExistentArticle(): void
    {
        $this->actingAs($this->comment->user)
            ->deleteJson("/comments/{999999999999}")
            ->assertNotFound();

        $this->assertModelExists($this->comment);
    }

    public function testDeleteForeignArticleComment(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->deleteJson("/comments/{$this->comment->id}")
            ->assertForbidden();

        $this->assertModelExists($this->comment);
    }

    public function testDeleteCommentWithoutAuth(): void
    {
        $this->deleteJson("/comments/{$this->comment->id}")
            ->assertUnauthorized();

        $this->assertModelExists($this->comment);
    }
}
