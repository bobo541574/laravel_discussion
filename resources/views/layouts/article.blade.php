@foreach ($articles as $article)
<div class="card shadow-lg mb-2" id="card_{{ $article->id }}">
    <div class="card-body pt-2">
        <div id="flash_{{ $article->id }}"></div>
        <div class="row card-title mb-0">
            <div class="col">
                <a href="{{ route('articles.timeline', $article->user->id) }}" class="card-link">
                    <img src="{{ asset($article->user->photo) }}" class="profile mr-3 rounded-circle" width="50px" height="50px" alt="user_img">
                    <b class="heading">{{ $article->user->name }}</b>
                </a>
            </div>
            @auth
            @if ($article->user_id == auth()->user()->id)
            <div class="dropdown mr-2 my-auto">
                <a class="btn btn-outline-none dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('articles.edit', $article->id) }}"><i
                            class="fas fa-pencil-alt mr-3"></i>Edit</a>
                    <div class="dropdown-divider"></div>

                    <!-- Button trigger modal -->
                    <button class="dropdown-item" data-toggle="modal" data-target="#delete"><i
                            class="far fa-trash-alt mr-3"></i>Delete</button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('articles.destroy', $article->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-bold" id="deleteModal"><i
                                        class="far fa-question-circle mr-2 text-secondary"></i>Delete
                                    Confirm!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 class="text-danger text-center">Sure!, you want to delete this
                                    article!!!</h5>
                                <input type="hidden" name="id" value="{{ $article->id }}">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancle</button>
                                <button type="submit" class="btn btn-danger">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            @endauth
        </div>
        <hr class="mt-1 mb-2">
        <h4 class="card-title mr-auto">{{ $article->title }}</h4>

        <div class="card-subtitle mb-2 text-muted small">
            {{ $article->created_at->diffForHumans() }}, Category : <b>{{ $article->category->name }}</b>
        </div>
        <p class="card-text" id="read_more_{{$article->id}}">{{ substr($article->body, 0, 150) }}... <a
                href="javascript:void(0)" class="card-link" onclick="readMore({{ $article }})">Read More</a></p>
    </div>
    <div class="card-footer">
        <a href="javascript:void(0)" class="btn btn-sm btn-light {{ $article->likeCheck ? 'text-primary' : '' }} like"
            id="like_{{ $article->id }}" onclick="like({{ $article->id }})" data-placement="top" title="like"
            data-toggle="tooltip">
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
        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-light comment" data-placement="top"
            title="comment" data-toggle="tooltip" onclick="comment({{ $article->id }})">
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
        <a href="{{ route('articles.show', $article->id) }}" class="card-link float-right"><b>View Detail &raquo;</b>
        </a>
    </div>
</div>
@endforeach
<div class="d-flex">
    <div class="mx-auto">
        {{$articles->appends(['category' => request()->query('category')])->links()}}
    </div>
</div>
