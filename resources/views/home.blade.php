<!-- home/ newsfeed page -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="list-group-item">
                <!-- show profile image in post box -->
                <img style=" float:left; border-radius:50%;" width="50px" height="50px"  src="{{ asset('images/profile/'.Auth::user()->image)}}" alt="profile">
                <div class="list-group">
                    <!-- define the form -->
                    <form method="POST" action="{{url('posts') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="post_area">
                            <textarea class="form-control" name="content" rows="5" maxlength="1000" style=" font-size: 18px; padding: 10px; resize: none ;overflow: hidden;  border: none;-webkit-box-shadow: none; " id="post" onkeyup="success()"
                              placeholder="What are you thinking... <?=$name = Auth::user()->name;?>"></textarea>
                        </div>
                        <div class="md-form">
                            <div style="float:right;" class="image-upload">
                                <label for="file-input">
                                    <img width="50px" height="50px" src="{{ asset('img/image.png') }}" />
                                </label>
                                <input style="display:none;" id="file-input" type="file" name="image" />
                            </div>
                            <button type="submit" id="btnSubmit" disabled class="btn purple-gradient float-right">{{ __('Post') }}</button>
                        </div>
                    </form>
                </div>
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
            <!-- if $posts has more than 0 posts -->
            @if (sizeof($posts)>0)
            <!-- for each posts in posts show single_post view -->
            @foreach($posts as $post)
            @include('post/single_post')
            @endforeach
            <li class="list-group-item">
              <!-- pages links-->
                {{$posts->links()}}
            </li>
            @else
            <!-- if there are posts show no posts message -->
            <li class="list-group-item">
                <h3  style="text-align:center">No posts yet</h3>
                <h5  style="text-align:center">why not search for you favorite Science personality </h5>
                <img style="display: block; margin-left: auto; margin-right: auto;" height="500px" width="500px"  src="{{ asset('img/noposts.png') }}" alt="{{ asset('img/avatar.png')}}">
            </li>
            @endif

        </div>
        @include('incs/side')
    </div>
</div>
@endsection
<!--
  <div class="card">
      <div class="card-body">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
          You are logged in!
      </div>
  </div>
  -->
