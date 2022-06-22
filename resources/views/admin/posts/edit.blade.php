<h1>Editar Post {{ $post->id }}</h1>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form action="{{ route('posts.update', ['post' => $post->id]) }}" method="post">
    @method('PUT')
    @csrf
    <input type="text" name="title" id="title" value="{{ old('title') ?? $post->title }}">
    <br />
    <textarea name="content" id="content" cols="30" rows="10">{{ old('content') ?? $post->content }}</textarea>
    <br />
    <button type="submit">Enviar</button>
</form>
