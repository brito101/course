<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $data = $request->all();
        if ($request->image->isValid()) {
            $nameFile = Str::slug($data['title']) . '.' . $request->image->getClientOriginalExtension();
            $data['image'] = $request->image->storeAs('posts', $nameFile);
        }
        Post::create($data);
        return redirect()->route('posts.index')->with('message', 'Post Criado com Sucesso');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (empty($post)) {
            return redirect()->route('posts.index');
        }

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if (empty($post)) {
            return redirect()->back();
        }

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if (empty($post)) {
            return redirect()->back();
        }

        $data = $request->all();
        if ($request->image && $request->image->isValid()) {
            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }
            $nameFile = Str::slug($data['title']) . '.' . $request->image->getClientOriginalExtension();
            $data['image'] = $request->image->storeAs('posts', $nameFile);
        }

        if ($post->update($data)) {
            return redirect()->route('posts.index')
                ->with('message', 'Post Editado com Sucesso');
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!empty($post)) {
            if (Storage::exists($post->image)) {
                Storage::delete($post->image);
            }
            $post->delete();
        }
        return redirect()->route('posts.index')
            ->with('message', 'Post Deletado');
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $posts = Post::where('title', 'LIKE', "%{$request->search}%")
            ->orWhere('content', 'LIKE', "%{$request->search}%")
            ->paginate();

        return view('admin.posts.index', compact('posts', 'filters'));
    }
}
