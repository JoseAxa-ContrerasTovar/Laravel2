@csrf

<label for="">Título</label>
<input class="form-control" type="text" name="title" value="{{ old('title', $category->title) }}">

<label for="">Slug</label>
<input class="form-control" type="text" name="slug" value="{{ old('slug', $category->slug) }}">

<button type="submit" class="btn btn-success mt-3">Enviar</button>
