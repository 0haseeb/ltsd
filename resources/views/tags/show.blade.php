<!-- page for hashtags/topices. -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ url("home") }}"> <img style="float:left;" src="{{ asset('img/back.png') }}" width="30px" height="30px" alt=""> </a>

                    <div style="padding-left:50px;">
                    <h2>&nbsp&nbsp#{{$tag->name}} </h2>
                    @if (Auth::User()->isFollowingtag($tag->id))
                        <form action="{{url('unfollowtag/' . $tag->name)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button style="float:left;border-radius:30px; border-width:10px;" type="submit" class="btn btn-outline-danger btn-rounded shadow-none" class="btn btn-danger">Unfollow</button>
                        </form>
                    @else
                          <form action="{{url('followtag/' . $tag->name)}}" method="POST">
                            {{ csrf_field() }}

                            <button style="float:left;border-radius:30px;" type="submit" class="btn btn-outline-primary btn-rounded shadow-none ">Follow </button>
                        </form>
                    @endif


                    </div>
                </li>
                @if (sizeof($posts)>0)
                @foreach($posts as $post)
                @include('post/single_post')
                @endforeach
                <li class="list-group-item">
                    {{$posts->links()}}
                </li>
                @else
                <li class="list-group-item">
                    <img style="display: block; margin-left: auto; margin-right: auto;" height="300px" width="300px" src="{{ asset('img/noposts.png') }}" alt="{{ asset('img/avatar.png')}}">
                </li>
                @endif

            </ul>
        </div>
        @include('incs/side')
    </div>
</div>
@endsection
