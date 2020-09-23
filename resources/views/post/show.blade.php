<!-- "page" for individial post -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ url("home") }}"> <img style="float:left;" src="{{ asset('img/back.png') }}" width="30px" height="30px" alt=""> </a>
                    <h4>&nbsp &nbsp Post </h4>
                </li>
                @include('post/single_post')
                <li class="list-group-item">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <img style=" float:left; border-radius:50%;" width="35px" height="35px" src="{{ asset('images/profile/'.Auth::user()->image)}}" alt="{{ asset('img/avatar.png')}}">
                            <ul class="list-group">
                                <!-- define the form -->
                                <form method="POST" action="{{action('PostController@comment')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="post_id" name="post_id" value="{{$post['id']}}">
                                    <div class="post_area">
                                        <textarea class="form-control" name="comment" rows="2" maxlength="1000" style=" font-size: 18px; padding: 10px; resize: none ;overflow: hidden;  border: none;-webkit-box-shadow: none; " id="post"
                                          onkeyup="success()" placeholder="Say something.. <?=$name = Auth::user()->name;?>"></textarea>
                                    </div>
                                    <div class="md-form">
                                        <button type="submit" id="btnSubmit" disabled class="btn purple-gradient float-right">{{ __('Comment') }}</button>
                                    </div>
                                </form>
                            </ul>
                        </li>
                        @foreach($comments as $comment)
                        @include('post/comment')
                        @endforeach
                        <li class="list-group-item">
                            {{$comments->links()}}
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        @include('incs/side')
    </div>
</div>
@endsection
