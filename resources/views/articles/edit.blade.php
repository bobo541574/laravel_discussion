@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('articles.update', $article->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" id="title" class="form-control" value="{{ $article->title }}" placeholder="Post Title">
            </div>
            <div class="form-group">
              <label for="body">Body</label>
              <textarea name="body" id="body" class="form-control" placeholder="Post Body">{{ $article->body }}</textarea>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" name="category_id" id="category" autocomplete="off">
                  <option value="0">---Select Category---</option>
                  @foreach ($categories as $category)
                      <option value="{{ $category->id }}" {{ $category->id == $article->category_id ? "selected" : '' }}>{{ $category->name }}</option>
                  @endforeach
              </select>
            </div>
            <input type="submit" class="btn btn-success" value="Update Article">
        </form>
    </div>
@endsection