@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ url()->previous() }}"> <img style="float:left;" src="{{ asset('img/back.png') }}" width="30px" height="30px" alt=""> </a>
                    <div style="padding-left:80px;">

                        <ul class="nav nav-pills nav-fill">
                            <li class="nav-item">
                              <form class="form-inline" method="GET" action="{{action('SearchController@findPosts')}}" enctype="multipart/form-data">
                                    <input type="hidden" id="custId" name="search" value="{{$q}}">
                                    <button type="submit" class="nav-link btn shadow-none   ">  <h4>Posts </h4></button>
                              </form>
                            </li>
                            <li class="nav-item">
                              <form class="form-inline" method="GET" action="{{action('SearchController@findUsers')}}" enctype="multipart/form-data">
                                    <input type="hidden" id="custId" name="search" value="{{$q}}">
                                    <button type="submit" class="nav-link active btn shadow-none">  <h4>Users </h4></button>
                              </form>
                            </li>
                            <li class="nav-item">
                              <form class="form-inline" method="GET" action="{{action('SearchController@findTags')}}" enctype="multipart/form-data">
                                    <input type="hidden" id="custId" name="search" value="{{$q}}">
                                    <button type="submit" class="nav-link btn shadow-none">  <h4>Topics </h4></button>
                              </form>
                            </li>
                        </ul>
                    </div>
                </li>
                @if (sizeof($users)>0)
                @foreach($users as $user)
                  @include('users/usercard')
                @endforeach
                <li class="list-group-item">
                    {{$users->links()}}
                </li>
                @else
                <li class="list-group-item">
                    <h3  style="text-align:center">No Users found</h3>
                    <h5  style="text-align:center">Try a different search query</h5>

                </li>
                @endif
            </ul>
        </div>
        @include('incs/side')
    </div>
</div>
@endsection
