@extends('layouts.app')

@section('content')

<div class="container-fluid">
    {{-- <div class="card pt-0">
        <div class="card-image">
            <img src="{{ asset('covers/cover.jpg') }}" width="100%" height="450px" alt="cover-img">
        </div>
    </div> --}}
    <div class="row justify-content-center my-1">
        <div class="col-md-3">
            @include('layouts.left')
        </div>
        <div class="col-md-6">
            @foreach ($articles as $article)
            <div class="card shadow-lg mb-2" id="card_{{ $article->id }}">
                <div class="card-body pt-2">
                    <div id="flash_{{ $article->id }}"></div>
                    <a href="{{ route('articles.timeline', $article->user->id) }}" class="card-link">
                        <img src="{{ asset($article->user->photo) }}" class="mr-3 rounded-circle" width="7%" alt="user_img">
                        <b style="font-size: 130%">{{ $article->user->name }}</b>
                    </a>
                    <a href="" class="card-link close"><strong class="h5 font-weight-bold">&times;</strong></a>
                    <hr class="mt-1 mb-2">
                    <h4 class="card-title mr-auto">{{ $article->title }}</h4>

                    <div class="card-subtitle mb-2 text-muted small">
                        {{ $article->created_at->diffForHumans() }}
                    </div>
                    <p class="card-text" id="read_more_{{$article->id}}">{{ substr($article->body, 0, 150) }}... <a
                            href="javascript:void(0)" class="card-link" onclick="readMore({{ $article }})">Read More</a>
                    </p>
                </div>
                <div class="card-footer">
                    <a href="javascript:void(0)"
                        class="btn btn-sm btn-light {{ $article->likeCheck ? 'text-primary' : '' }} like"
                        id="like_{{ $article->id }}" onclick="like({{ $article->id }})" data-placement="top"
                        title="like" data-toggle="tooltip">
                        <i class="fa fa-thumbs-up">
                            <sup>{{ ($article->likeCount) }}</sup>
                        </i>
                    </a>
                    <a href="javascript:void(0)"
                        class="btn btn-sm btn-light {{ $article->dislikeCheck ? 'text-danger' : '' }} dislike"
                        id="dislike_{{ $article->id }}" data-placement="top" title="dislike" data-toggle="tooltip"
                        onclick="dislike({{ $article->id }})">
                        <i class="fa fa-thumbs-down">
                            <sup>{{ ($article->dislikeCount) }}</sup>
                        </i>
                    </a>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-light comment"
                        data-placement="top" title="comment" data-toggle="tooltip"
                        onclick="comment({{ $article->id }})">
                        <i class="fas fa-comment-alt
                                @auth
                                    @foreach ($article->comments as $comment)
                                        {{ $comment->user->id == auth()->user()->id ? 'text-info' : '' }}
                                    @endforeach
                                @endauth
                            ">
                            <sup>{{ (count($article->comments) ? count($article->comments) : '') }}</sup>
                        </i>
                    </a>
                    <a href="{{ route('articles.show', $article->id) }}" class="card-link float-right"><b>View Detail
                            &raquo;</b> </a>
                </div>
            </div>
            @endforeach
            <div class="row">
                <div class="mx-auto">
                    {{ $articles->links() }}
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
    function readMore(article) {
        let id = article.id;
        let content = article.body;
        let read_more = "";
        read_more += `${content}`;
        $(".card #read_more_" + id).html(read_more);
    }

</script>
@endpush
