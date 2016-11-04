<?php

namespace CodePress\CodePost\Tests\Controllers;


use CodePress\CodePost\Controllers\AdminPostController;
use CodePress\CodePost\Controllers\Controller;
use CodePress\CodePost\Repository\PostRepositoryEloquent;
use CodePress\CodePost\Tests\AbstractTestCase;
use Illuminate\Contracts\Routing\ResponseFactory;
use Mockery as m;

class AdminPostControllerTest extends AbstractTestCase
{

    public function test_should_extends_from_controller()
    {
        $repository = m::mock(PostRepositoryEloquent::class);
        $response = m::mock(ResponseFactory::class);
        $controller = new AdminPostController($response, $repository);

        $this->assertInstanceOf(Controller::class, $controller);
    }

    public function test_controller_should_run_index_method_and_return_correct_arguments()
    {
        $repository = m::mock(PostRepositoryEloquent::class);
        $response = m::mock(ResponseFactory::class);
        $controller = new AdminPostController($response, $repository);
        $html = m::mock();

        $postsResult = ['Post 1', 'Post 2'];

        $repository->shouldReceive('all')->andReturn($postsResult);

        $response->shouldReceive('view')
            ->with('codepost::index', ['posts' => $postsResult])
            ->andReturn($html);

        $this->assertEquals($controller->index(), $html);

    }

}