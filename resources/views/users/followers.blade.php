<!-- "Page" Shows list of user followers -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{url($user->username)}}"> <img style="float:left;" src="{{ asset('img/back.png') }}" width="30px" height="30px" alt=""> </a>
                    <div style="padding-left:50px;">
                        <h2>{{ $user->name }} </h2>
                        <p style="color:grey;float:left;">&nbsp@ </p>
                        <p style="color:grey;">{{$user->username}}</p>
                    </div>
                    <div style="padding-left:80px;">

                        <ul class="nav nav-pills nav-fill">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{url($user->username . '/followers')}}">
                                    <h4>Followers </h4>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url($user->username . '/following')}}">
                                    <h4>Followings </h4>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url($user->username . '/usertags')}}">
                                    <h4>Topices </h4>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @foreach($users as $user)
                @include('users/usercard')
                @endforeach
            </ul>
        </div>
        @include('incs/side')
    </div>
</div>
@endsection
