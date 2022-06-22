<a href="{{ route('posts.index') }}">Posts</a>


<h1>Detalhes do Post {{ $post->id }}</h1>
<ul>
    <li>Título: {{ $post->title }}</li>
    <li>Conteúdo: {{ $post->content }}</li>
</ul>

<form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post">
    @method('DELETE')
    @csrf
    <button type="submit">Deletar Post {{ $post->title }}</button>
</form>
