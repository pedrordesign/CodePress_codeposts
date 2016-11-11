<?php

namespace CodePress\CodePost\Controllers;

use CodePress\CodePost\Repository\PostRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{

    private $repository;
    private $response;

    public function __construct(ResponseFactory $response, PostRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function index()
    {
        $posts = $this->repository->all();
        return $this->response->view('codepost::index', compact('posts'));

    }

    public function create()
    {
        $posts = $this->repository->all();
        return view('codepost::create', compact('posts'));

    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('admin.posts.index');
    }

    public function edit($id)
    {
        $post = $this->repository->find($id);
        $posts = $this->repository->all();
        return $this->response->view('codepost::edit', compact('post', 'posts'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        //var_dump($data); die;
        if(!isset($data['active'])){
            $data['active'] = false;
        }else{
            $data['active'] = true;
        }

        if(!isset($data['parent_id']) || (isset($data['parent_id']) && $data['parent_id'] == 0)){
            $data['parent_id'] = null;
        }

        $post = $this-$this->repository->update($data, $id);
        //var_dump($post); die;
        return redirect()->route('admin.posts.index');
    }

    public function updateState(Request $request, $id){ //, $state
        $this->authorize('updateState_post');
        $this->repository->updateState($id, $request->get('state'));
        return redirect()->route('admin.posts.edit', ['id' => $id]);
    }

}