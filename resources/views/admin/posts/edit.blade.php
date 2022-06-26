@extends('admin.layout.master')

@section('title', 'Editar Post')

@section('content')
    <h1 class="text-center text-3xl uppercase font-black my-4">Editar Post {{ $post->id }}</h1>

    <div class="w-11/12 p-12 bg-white sm:w-8/12 md:w-1/2 lg:w-5/12 mx-auto">

        <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.posts._partials.form')
        </form>
    @endsection
