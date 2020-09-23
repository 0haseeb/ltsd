<!-- "Page" Shows list of post user has liked (public anyone logged in can see this page) -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-none">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url("home") }}"> <img style="float:left;" src="{{ asset('img/back.png') }}" width="30px" height="30px" alt=""> </a>
                        <h2>&nbsp &nbsp {{ $user->name }} </h2>
                    </li>
                    <li style="float: left;" class="list-group-item">
                        @if($user->id === Auth::id())
                        <button style="float:right;border-radius:30px;" type="button" data-toggle="modal" data-name="{{Auth::user()->name}}" data-user_id="{{Auth::user()->id}}" data-bio="{{Auth::user()->bio}}" data-target="#editprofileModal"
                          class="btn btn-outline-primary btn-rounded shadow-none">Edit profile</button>
                        @elseif (Auth::User()->isFollowing($user->id))
                        <td>
                            <form action="{{url('unfollow/' . $user->username)}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button style="float:right;border-radius:30px;" type="submit" class="btn btn-outline-danger btn-rounded shadow-none" class="btn btn-danger">
                                    <i class="fa fa-btn fa-trash"></i>Unfollow
                                </button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="{{url('follow/' . $user->username)}}" method="POST">
                                {{ csrf_field() }}

                                <button style="float:right;border-radius:30px;" type="submit" class="btn btn-outline-primary btn-rounded shadow-none ">Follow </button>
                            </form>
                        </td>
                        @endif
                        <img style="display: inline;  border-radius: 50%;  " width="130px" height="130px" src="{{ asset('images/profile/'.$user->image)}}">
                        <br />
                        <br />
                        @foreach($tags as $tag)
                        <a href="{{url('hashtag/'.$tag->name)}}" class="badge badge-primary">. {{$tag->name}}</a>
                        @endforeach
                        <h2>{{$user->name }} </h2>
                        <p style="color:grey;float:left;">&nbsp@ </p>
                        <p style="color:grey;">{{$user->username}}</p>
                        <p>{{$user->bio}}</p>
                        <a href="{{url($user->username. '/followers')}}">
                            <h5 style="float:left; font-weight: bold;">{{$followerscount}}</h5>
                            <h5 style="float:left;">&nbspFollowers</h5>
                        </a>
                        <a href="{{url($user->username. '/following')}}">
                            <h5 style="float:left; font-weight: bold;">&nbsp &nbsp &nbsp{{$followingcount}}</h5>
                            <h5 style="float:left;">&nbspFollowing</h5>
                        </a>
                        <a href="{{url($user->username. '/usertags')}}">
                            <h5 style="float:left; font-weight: bold;">&nbsp &nbsp &nbsp{{$Topicscount}}</h5>
                            <h5 style="float:left;">&nbspTopices</h5>
                        </a>
                    </li>
                </ul>
            </div>
            <br />
            <!-- display the errors -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul> @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li> @endforeach
                </ul>
            </div><br />
            @endif
            <!-- display the success status -->
            @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
                {{header("Refresh:2")}}
            </div>
            @endif

            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="{{url($user->username)}}">
                        <h4> {{$Postscount}} Posts </h4>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{url($user->username. '/likes' )}}">
                        <h4>{{$Likescount}} Likes </h4>
                    </a>
                </li>
            </ul>

            <div class="card shadow-none">
                @if (sizeof($likedposts)>0)
                @foreach($likedposts as $post)
                @include('post/single_post')
                @endforeach
                <li class="list-group-item">
                    {{$likedposts->links()}}
                </li>
                @else
                <li class="list-group-item">
                    <img style="display: block; margin-left: auto; margin-right: auto;" height="300px" width="300px" src="{{ asset('img/noposts.png') }}" alt="{{ asset('img/avatar.png')}}">
                </li>
                @endif
            </div>
        </div>
        @include('incs/side')
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editprofileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{action('ProfileController@update', 'editProfile')}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bio">{{ __('Bio') }}</label>
                        <textarea class="form-control" name="bio" id="bio" rows="2" value="{{ old('bio') }}" autocomplete="name" class="form-control @error('bio') is-invalid @enderror" style="  resize: none; overflow: hidden; "></textarea>
                        @error('bio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label>Profile Image: </label>
                    <input type="file" name="image" />
                </div>
                <div class="modal-footer">
                    <div class="md-form">
                        <button type="button" class="btn aqua-gradient" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn purple-gradient">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
