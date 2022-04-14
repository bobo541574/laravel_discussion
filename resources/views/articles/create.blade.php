@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('articles.store') }}" method="post">
            @csrf
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" name="title" id="title" class="form-control" placeholder="Post Title">
            </div>
            <div class="form-group">
              <label for="body">Body</label>
              <textarea name="body" id="body" class="form-control" placeholder="Post Body"></textarea>
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-control" name="category_id" id="category">
                  @foreach ($categories as $category)
                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
              </select>
            </div>
            <input type="submit" class="btn btn-success" value="Add Article">
        </form>
    </div>
@endsection