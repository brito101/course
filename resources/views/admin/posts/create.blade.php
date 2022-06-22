<h1>Cadastrar Novo Post</h1>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
<form action="{{ route('posts.store') }}" method="post">
    @csrf
    <input type="text" name="title" id="title" value="{{ old('title') }}">
    <br />
    <textarea name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
    <br />
    <button type="submit">Enviar</button>
</form>
