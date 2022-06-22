<a href="{{ route('posts.create') }}">Criar novo Post</a>

@if (session('message'))
    <div>{{ session('message') }}</div>
@endif

<h1>Posts</h1>

<form action="{{ route('posts.search') }}" method="post">
    @csrf
    <input type="text" name="search" id="search" value="{{ old('search') }}" placeholder="Título">
    <button type="submit">Pesquisar</button>
</form>

@foreach ($posts as $post)
    <p>{{ $post->title }} <a href="{{ route('posts.show', ['post' => $post->id]) }}">Detalhes</a> | <a
            href="{{ route('posts.edit', ['post' => $post->id]) }}">Editar</a></p>
@endforeach

<div>
    @if (isset($filters))
        {{ $posts->appends($filters)->links() }}
    @else
        {{ $posts->links() }}
    @endif
</div>
