<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mdb.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">


</head>

<body>
    <div id="app">
        <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                        @else
                        <form class="form-inline" method="GET" action="{{action('SearchController@findPosts')}}" enctype="multipart/form-data">
                            <input class="form-control mr-sm-2 bg-dark" name="search" type="search" placeholder="Find posts users topics" aria-label="Search">
                        </form>
                        @endguest
                    </ul>

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

                        <li class="nav-item">
                            <a class="nav-link" href="{{url(Auth::user()->username)}}">
                                <img style="border-radius:50%" width="25px" height="25px" src="{{ asset('images/profile/'.Auth::user()->image)}}" alt="Profile Image"> <span class="caret"></span>
                                &nbsp{{Auth::user()->name}}</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#"><img width="25px" height="25px" src="{{ asset('img/messages.png')}} " alt="Messages"></a>
                        </li> -->

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img width="25px" height="25px" src="{{ asset('img/notification.png')}} " alt="Notification"> <span class="caret"></span>
                                @if($notifcount>0)
                                <h4 style="  position: absolute;right: 2px;top: 2px;"><b>{{$notifcount}}</b></h4>
                                @endif
                            </a>

                            <div style="max-height:500px; overflow-y:auto" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <ul class="list-group ">
                                    <li class="list-group-item">
                                        <h4><b>Notifications</b></h4>
                                    </li>
                                    @if($notifcount>0)
                                    @foreach(Auth::user()->notifications as $notification)
                                    @if($notification->unread())
                                    <li class="list-group-item dropdown-item list-group-item-action list-group-item-primary">
                                        <a style="padding:0px" href="{{action('HomeController@showNt', $notification->id)}}">
                                            <img style="border-radius:50%;float:left" width="75px" height="75px" src="{{ asset('images/profile/'.$notification->data['user_image'])}}" alt="userimage">
                                            @if($notification->type === "App\Notifications\UserFollowed" )
                                            <h5 style="padding-left:85px; padding-Right:85px"><b>@</b><b>{{$notification->data['username']}} </b> Started following you &nbsp <span
                                                  class="badge badge-primary badge-pill">{{$notification->created_at->diffForHumans()}}</span> </h5>
                                            @elseif($notification->type === "App\Notifications\PostComment" )
                                            @if(!$notification->data['post_image']==null)
                                            <img style="float:Right" width="75px" height="75px" src="{{ asset('images/post/'.$notification->data['post_image'])}}" alt="Postimage">
                                            @endif
                                            <h5 style="padding-left:85px; padding-Right:85px"><b>@</b><b>{{$notification->data['username']}} </b> Commented on your Post &nbsp <span
                                                  class="badge badge-primary badge-pill">{{$notification->created_at->diffForHumans()}}</span> </h5>
                                            <p style="padding-left:85px; padding-Right:85px">{{$notification->data['comment']}}</p>
                                            @elseif($notification->type === "App\Notifications\PostLiked" )
                                            @if(!$notification->data['post_image']==null)
                                            <img style="float:Right" width="75px" height="75px" src="{{ asset('images/post/'.$notification->data['post_image'])}}" alt="Postimage">
                                            @endif
                                            <h5 style="padding-left:85px; padding-Right:85px"><b>@</b><b>{{$notification->data['username']}} </b> Liked your Post &nbsp <span
                                                  class="badge badge-primary badge-pill">{{$notification->created_at->diffForHumans()}}</span> </h5>
                                            <p style="padding-left:85px; padding-Right:85px">{{$notification->data['post_content']}}</p>
                                            @endif
                                        </a>
                                    </li>
                                    @else
                                    <li class="list-group-item dropdown-item">
                                      <a style="padding:0px" href="{{action('HomeController@showNt', $notification->id)}}">
                                          <img style="border-radius:50%;float:left" width="75px" height="75px" src="{{ asset('images/profile/'.$notification->data['user_image'])}}" alt="userimage">
                                          @if($notification->type === "App\Notifications\UserFollowed" )
                                          <h5 style="padding-left:85px; padding-Right:85px"><b>@</b><b>{{$notification->data['username']}} </b> Started following you &nbsp <span
                                                class="badge badge-primary badge-pill">{{$notification->created_at->diffForHumans()}}</span> </h5>
                                          @elseif($notification->type === "App\Notifications\PostComment" )
                                          <h5 style="padding-left:85px; padding-Right:85px"><b>@</b><b>{{$notification->data['username']}} </b> Commented on your Post &nbsp <span
                                                class="badge badge-primary badge-pill">{{$notification->created_at->diffForHumans()}}</span> </h5>
                                          <p style="padding-left:85px; padding-Right:85px">{{$notification->data['comment']}}</p>
                                          @elseif($notification->type === "App\Notifications\PostLiked" )
                                          @if(!$notification->data['post_image']==null)
                                          <img style="float:Right" width="75px" height="75px" src="{{ asset('images/post/'.$notification->data['post_image'])}}" alt="Postimage">
                                          @endif
                                          <h5 style="padding-left:85px; padding-Right:85px"><b>@</b><b>{{$notification->data['username']}} </b> Liked your Post &nbsp <span
                                                class="badge badge-primary badge-pill">{{$notification->created_at->diffForHumans()}}</span> </h5>
                                          <p style="padding-left:85px; padding-Right:85px">{{$notification->data['post_content']}}</p>
                                          @endif
                                      </a>
                                    </li>
                                    @endif
                                    @endforeach
                                    @else
                                    <li class="list-group-item dropdown-item">
                                      <h5>No New Notifications</h5>
                                    </li>

                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                 <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('settings/account')}}">Settings</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/mdb.min.js') }}"></script>
    <script src="{{ asset('js/jquery.textArea.js') }}"></script>
    <script src="{{ asset('js/cusstom.js') }}"></script>

    <!--
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.5/lib/darkmode-js.min.js"></script>
    <script>
        import Darkmode from 'darkmode-js';s
        new Darkmode().showWidget();
    </script> -->

</body>

</html>
