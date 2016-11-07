<?php

namespace CodePress\CodeComment\Tests\Models;

use CodePress\CodePost\Models\Comment;
use CodePress\CodePost\Models\Post;
use CodePress\CodePost\Tests\AbstractTestCase;
use Illuminate\Validation\Validator;
use Mockery as m;

class CommentTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }

    public function test_inject_validator_in_comment_model()
    {
        $comment = new Comment();
        $validator = m::mock(Validator::class);
        $comment->setValidator($validator);

        $this->assertEquals($comment->getValidator(), $validator);
    }

    public function test_should_check_if_it_is_valid_when_it_is()
    {
        $comment = new Comment();
        $comment->content = 'Conteudo do comment';

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
                'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'content' => 'Conteudo do comment'
        ]);
        $validator->shouldReceive('fails')->andReturn(false);

        $comment->setValidator($validator);

        $this->assertTrue($comment->isValid());
    }

    public function test_should_check_if_it_is_invalid_when_it_is()
    {
        $comment = new Comment();
        $comment->content = '';

        $messageBag = m::mock('Illuminate\Support\MessageBag');

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'content' => ''
        ]);
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('errors')->andReturn($messageBag);

        $comment->setValidator($validator);
        $this->assertFalse($comment->isValid());
        $this->assertEquals($messageBag, $comment->errors);
    }

    public function test_check_if_a_comment_can_be_persisted()
    {
        $post = Post::create([
            'title' => 'Titulo do post',
            'content' => 'Conteudo do post'
        ]);
        $comment = Comment::create([
            'content' => 'Conteudo do comment',
            'post_id' => $post->id
        ]);
        $this->assertEquals('Conteudo do comment', $comment->content);


        $comment = Comment::all()->first();
        $this->assertEquals('Conteudo do comment', $comment->content);

        $post = Post::find(1)->first();
        $this->assertEquals('Titulo do post', $post->title);


    }
    public function test_can_validate_comment()
    {
        $comment = new Comment();
        $comment->content = 'Conteudo do comment';

        $factory = $this->app->make('Illuminate\Validation\Factory');

        $validator = $factory->make([],[]);


        $comment->setValidator($validator);
        $this->assertTrue($comment->isValid());
        $comment->content = null;
        $this->assertFalse($comment->isValid());

    }

    public function test_can_force_delete_all_from_relationship(){

        $post = Post::create([
            'title' => 'Titulo do post',
            'content' => 'Conteudo do post'
        ]);
        Comment::create([
            'content' => 'Conteudo do comment 1',
            'post_id' => $post->id
        ]);
        Comment::create([
            'content' => 'Conteudo do comment 2',
            'post_id' => $post->id
        ]);

        $post->comments()->forceDelete();

        $this->assertCount(0, $post->comments()->get());
        
    }

    public function test_can_force_restore_delete_all_from_relationship(){

        $post = Post::create([
            'title' => 'Titulo do post',
            'content' => 'Conteudo do post'
        ]);
        Comment::create([
            'content' => 'Conteudo do comment 1',
            'post_id' => $post->id
        ]);
        Comment::create([
            'content' => 'Conteudo do comment 2',
            'post_id' => $post->id
        ]);

        $post->comments()->Delete();

        $this->assertCount(0, $post->comments()->get());

        $post->comments()->restore();

        $this->assertCount(2, $post->comments()->get());

    }

}