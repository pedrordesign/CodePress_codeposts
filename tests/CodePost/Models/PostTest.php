<?php

namespace CodePress\CodePost\Tests\Models;

use CodePress\CodePost\Models\Post;
use CodePress\CodePost\Tests\AbstractTestCase;
use Illuminate\Validation\Validator;
use Mockery as m;

class PostTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }

    public function test_inject_validator_in_post_model()
    {
        $post = new Post();
        $validator = m::mock(Validator::class);
        $post->setValidator($validator);

        $this->assertEquals($post->getValidator(), $validator);
    }

    public function test_should_check_if_it_is_valid_when_it_is()
    {
        $post = new Post();
        $post->title = 'Post Test';
        $post->content = 'Conteudo do post';

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
                'title' => 'required|max:55',
                'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'title' => 'Post Test',
            'content' => 'Conteudo do post'
        ]);
        $validator->shouldReceive('fails')->andReturn(false);

        $post->setValidator($validator);

        $this->assertTrue($post->isValid());
    }

    public function test_should_check_if_it_is_invalid_when_it_is()
    {
        $post = new Post();
        $post->title = 'Post Test';

        $messageBag = m::mock('Illuminate\Support\MessageBag');

        $validator = m::mock(Validator::class);
        $validator->shouldReceive('setRules')->with([
            'title' => 'required|max:55',
            'content' => 'required'
        ]);
        $validator->shouldReceive('setData')->with([
            'title' => 'Post Test'
        ]);
        $validator->shouldReceive('fails')->andReturn(true);
        $validator->shouldReceive('errors')->andReturn($messageBag);

        $post->setValidator($validator);
        $this->assertFalse($post->isValid());
        $this->assertEquals($messageBag, $post->errors);
    }

    public function test_check_if_a_post_can_be_persisted()
    {

        $post = Post::create(['title'=>'Post Test', 'content' => 'Conteudo do post']);
        $this->assertEquals('Post Test', $post->title);
        $this->assertEquals('Conteudo do post', $post->content);

        $post = Post::all()->first();
        $this->assertEquals('Post Test', $post->title);
        $this->assertEquals('Conteudo do post', $post->content);

    }

    public function test_can_validate_post()
    {
        $post = new Post();
        $post->title = 'Post Test';
        $post->content = 'Conteudo do post';

        $factory = $this->app->make('Illuminate\Validation\Factory');

        $validator = $factory->make([],[]);


        $post->setValidator($validator);
        $this->assertTrue($post->isValid());

        $post->title = null;
        $this->assertFalse($post->isValid());

    }

    public function test_can_sluggable(){
        $post = Post::create(['title'=>'Post Test', 'content' => 'Conteudo do post']);
        $this->assertEquals($post->slug, "post-test");
        $post = Post::create(['title'=>'Post Test', 'content' => 'Conteudo do post']);
        $this->assertEquals($post->slug, "post-test-1");
        $post = Post::findBySlug("post-test-1");
        $this->assertInstanceOf(Post::class, $post);
    }

}