@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-2 shadow-lg rounded-lg">
                    <div class="card-body">
                        <div id="flash_{{ $article->id }}"></div>
                        <div class="row card-title">
                            <div class="col">
                                <h4 class="card-title">{{ $article->title }}</h4>
                            </div>
                            @auth
                                @if ($article->user_id == auth()->user()->id)
                                    <div class="dropdown mr-2">
                                        <a class="btn btn-outline-none dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
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
                                    <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                                        aria-labelledby="deleteModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('articles.destroy', $article->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold" id="deleteModal"><i
                                                                class="far fa-question-circle mr-2 text-secondary"></i>Delete
                                                            Confirm!</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="text-danger text-center">Sure!, you want to delete this
                                                            article!!!</h5>
                                                        <input type="hidden" name="id" value="{{ $article->id }}">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancle</button>
                                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        <div class="card-subtitle mb-2 text-muted small">
                            {{ $article->created_at->diffForHumans() }},
                            Category: <b>{{ $article->category->name }}</b>
                        </div>
                        <p class="card-text">{{ $article->body }}</p>
                    </div>
                    <div class="card-footer py-1">
                        <a href="javascript:void(0)"
                            class="btn btn-sm btn-light {{ $article->likeCheck ? 'text-primary' : '' }} like mr-1"
                            id="like_{{ $article->id }}" onclick="like({{ $article->id }})" data-placement="top"
                            title="like" data-toggle="tooltip">
                            <i class="fa fa-thumbs-up">
                                <sup>{{ $article->likeCount }}</sup>
                            </i>
                        </a>
                        <a href="javascript:void(0)"
                            class="btn btn-sm btn-light {{ $article->dislikeCheck ? 'text-danger' : '' }} dislike"
                            id="dislike_{{ $article->id }}" data-placement="top" title="dislike" data-toggle="tooltip"
                            onclick="dislike({{ $article->id }})">
                            <i class="fa fa-thumbs-down">
                                <sup>{{ $article->dislikeCount }}</sup>
                            </i>
                        </a>
                    </div>
                </div>
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body">
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <textarea name="content" class="form-control mb-2" placeholder="New Comment"></textarea>
                            <input type="submit" class="btn btn-secondary" value="Add Comment">
                        </form>
                    </div>
                </div>
                <ul class="list-group my-2 shadow-lg rounded-lg">
                    <li class="list-group-item active">
                        <b>Comments ({{ count($article->comments) }})</b>
                    </li>
                    @foreach ($article->comments as $comment)
                        <li class="list-group-item {{ $comment->commentCheck ? 'bg-comment' : '' }}">
                            <div id="content-{{ $comment->id }}">
                                <span>{{ $comment->body }}</span>
                                @if (strlen($comment->content) > 240 == 'true')
                                    <a href="javascript:void(0)" class="card-link" id="body_{{ $comment->id }}"
                                        onclick="readMore({{ $comment }})"> ...Read More</a>
                                @endif
                                <div class="small">
                                    By <b>{{ $comment->user->name }}</b>,
                                    {{ $comment->created_at->diffForHumans() }}
                                </div>
                                <div class="row py-2 px-3">
                                    <a href="javascript:void(0)" id="reply_{{ $comment->id }}"
                                        onclick="reply({{ $comment->id }})"
                                        class="btn btn-sm btn-light text-info reply mr-1" data-toggle="tooltip"
                                        data-placement="top" title="reply">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-light {{ $comment->likeCheck ? 'text-primary' : '' }} like-comment mr-1"
                                        id="like_comment{{ $comment->id }}" onclick="likeComment ({{ $comment->id }})"
                                        data-placement="top" title="like" data-toggle="tooltip">
                                        <i class="fa fa-thumbs-up">
                                            <sup>{{ $comment->likeCount }}</sup>
                                        </i>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="btn btn-sm btn-light {{ $comment->dislikeCheck ? 'text-danger' : '' }} dislike-comment mr-1"
                                        id="dislike_comment{{ $comment->id }}" data-placement="top" title="dislike"
                                        data-toggle="tooltip" onclick="dislikeComment({{ $comment->id }})">
                                        <i class="fa fa-thumbs-down">
                                            <sup>{{ $comment->dislikeCount }}</sup>
                                        </i>
                                    </a>
                                    @auth
                                        @if (auth()->user()->id == $comment->user_id)
                                            <a href="javascript:void(0)" class="btn btn-sm btn-secondary mr-1"
                                                id="comment-{{ $comment->id }}" data-toggle="tooltip" data-placement="top"
                                                title="edit" onclick="edit({{ $comment }})">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="btn btn-sm btn-warning"><i class="fa fa-trash"
                                                        data-toggle="tooltip" data-placement="top" title="delete"></i></button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <ul class="list-group">
                                    @foreach ($comment->replies as $reply)
                                        <p class="m-0 font-weight-bold" style="font-size: 80%">
                                            {{ $loop->first ? 'Replies' : '' }}</p>
                                        <li class="list-group-item" style="font-size: 80%">{{ $reply->content }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function readMore(comment) {
            let id = comment.id;
            let content = comment.content;
            let read_more = "";
            read_more += `${content}`;
            $("#content-" + id + " span").html(read_more);
            $("#content-" + id + " #body_" + id).remove('a');
        }


        function edit(comment) {
            let update_comment = '';
            let id = comment.id;
            let content = comment.content;
            let user_id = comment.user.id;
            let article_id = comment.article_id;
            console.log(comment);
            update_comment += `
                <form action="{{ url('comments/${id}') }}" method="post">
                    @csrf
                    @method("PUT")
                    <textarea name="content" id="content-${id}" class="form-control my-2" placeholder="Comment">${content}</textarea>
                    <button type="submit" class="btn btn-sm btn-light mr-1"><i class="fa fa-cloud-upload-alt"  data-toggle="tooltip" data-placement="top" title="update"></i></button>
                    <a href="{{ url('articles/${article_id}') }}" class="btn btn-sm btn-secondary mr-2"  data-toggle="tooltip" data-placement="top" title="cancle"><i class="fa fa-times-circle"></i></a>
                </form>
            `;
            $("#content-" + id).html(update_comment);
        }

        function reply(id) {
            let reply = '';
            $("#to_reply_" + id).remove("div");

            reply += `
                <div id="to_reply_${id}">
                    <form action="{{ url('replies') }}" method="post">
                        @csrf
                        <input type="hidden" name="comment_id" value="${id}" />
                        <textarea name="content" class="form-control my-2" placeholder="Reply"></textarea>
                        <button type="submit" class="btn btn-sm btn-light mr-1"><i class="fa fa-cloud-upload-alt"  data-toggle="tooltip" data-placement="top" title="update"></i></button>
                        <a href="javascript:void(0)" onclick="no_reply(${id})" class="btn btn-sm btn-secondary mr-2"  data-toggle="tooltip" data-placement="top" title="cancle"><i class="fa fa-times-circle"></i></a>
                    </form>
                </div>
            `;
            $("#content-" + id).append(reply);
        }

        function no_reply(id) {
            $("#to_reply_" + id).remove("div");
        }
    </script>
@endpush
