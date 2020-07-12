@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center my-1">
        <div class="col-md-3">
            @include('layouts.left')
        </div>
        <div class="col-md-6">
            <div class="card mb-2 shadow-lg">
                <div class="card-body">
                    @foreach ($users as $user)
                    <a href="{{ route('articles.index', $user->id) }}" class="text-decoration-none">
                        <h4 class="card-title font-weight-bolder">
                            <img src="{{ $user->photo }}" class="rounded-circle mr-2" width="50px" height="50px" alt="">
                            {{ $user->name }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            @include('layouts.right')
        </div>
    </div>
</div>
    
@endsection

@push('script')
    <script type="text/javascript">

    </script>
@endpush

