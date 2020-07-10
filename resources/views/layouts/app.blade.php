<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
    {{-- <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand text-uppercase font-weight-bolder px-2 rounded-lg" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item like">
                                <a href="{{ route('articles.create') }}" class="nav-link text-success"> + Add Article</a>
                            </li>
                        </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li> --}}

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('flashmessage')
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> --}}

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> --}}
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        })
        window.setTimeout(function() {
            $(".alert").fadeTo(5000, 0).slideUp(5000, function(){
                $(this).remove(); 
            });
        }, 5000);

        function like(id) {
            $.post("{{route('likes')}}", {id:id}, function(response) {
                console.log(response);
                var error = "";
                if(response == 401)
                {
                    error += `
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>Errors! <hr></strong>	
                            <strong>You need to login!!!</strong>
                    </div>
                    `;
                    $('#flash_'+id).html(error);
                }  else if(response.status == 201) {
                    $('#like_'+id).addClass('text-primary');
                    $('#dislike_'+id).removeClass('text-danger');
                    $('#like_'+id +' i sup').html(response.likeCount);
                    $('#dislike_'+id +' i sup').html(response.dislikeCount);
                } else if(response.status == 200) {
                    $('#like_'+id).removeClass('text-primary');
                    $('#like_'+id +' i sup').html(response.likeCount);
                }
            })
        }

        function dislike(id) {
            $.post("{{route('dislikes')}}", {id:id}, function(response) {
                console.log(response);
                var error = "";
                if(response == 401)
                {
                    error += `
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>Errors! <hr></strong>	
                            <strong>You need to login!!!</strong>
                    </div>
                    `;
                    $('#flash_'+id).html(error);
                }  else if(response.status == 201) {
                    $('#dislike_'+id).addClass('text-danger');
                    $('#dislike_'+id +' i sup').html(response.dislikeCount);
                    $('#like_'+id).removeClass('text-primary');
                    $('#like_'+id +' i sup').html(response.likeCount);
                } else if(response.status == 200) {
                    $('#dislike_'+id).removeClass('text-danger');
                    $('#dislike_'+id +' i sup').html(response.dislikeCount);
                }
            })
        }

        function likeComment(id) {
            $.post("{{route('likes-comment')}}", {id:id}, function(response) {
                console.log(response);
                var error = "";
                if(response == 401)
                {
                    error += `
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>Errors! <hr></strong>	
                            <strong>You need to login!!!</strong>
                    </div>
                    `;
                    $('#flash_'+id).html(error);
                }  else if(response.status == 201) {
                    $('#like-comment_'+id).addClass('text-primary');
                    $('#like-comment_'+id +' i sup').html(response.likeCount);
                } else if(response.status == 200) {
                    $('#like-comment_'+id).removeClass('text-primary');
                    $('#like-comment_'+id +' i sup').html(response.likeCount);
                }
            })
        }

    </script> 

    @stack('script')
    <script src="http://unpkg.com/turbolinks"></script>
    
</body>
</html>
