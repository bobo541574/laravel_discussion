@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('users.profile-update', $user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                value="{{ $user->email }}" disabled>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control-file" name="photo" id="photo" placeholder="Photo">
            <img src="{{ asset($user->photo) }}" class="my-2" width="75px" height="75px" alt="user_photo">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password"
            class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <input type="password"
            class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
        </div>
        <input type="submit" class="btn btn-primary" value="Save">
    </form>
</div>
@endsection
