<!-- Topices "cards" on User topics page.(cards for individual topices) -->
<li class="list-group-item">
    <img style="display: inline; float:left; " width="30px" height="30px" src="{{ asset('img/topic.png')}}">
    <div style="padding-left:40px;">
        <a href="{{url('hashtag/' . $tag->name)}}">
            <h5 style="float:left;  font-weight: 900;">{{$tag->name}}</h5>
        </a>
        @if (Auth::User()->isFollowingtag($tag->id))
        <form action="{{url('unfollowtag/' . $tag->name)}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button style="float:right;border-radius:30px; border-width:10px;" type="submit" class="btn btn-outline-danger btn-rounded shadow-none" class="btn btn-danger">Unfollow</button>
        </form>
        @else
        <form action="{{url('followtag/' . $tag->name)}}" method="POST">
            {{ csrf_field() }}
            <button style="float:right;border-radius:30px;" type="submit" class="btn btn-outline-primary btn-rounded shadow-none ">Follow </button>
        </form>
        @endif
        @if (Auth::User()->isFollowingtag($tag->id))
        @if (Auth::User()->isFavoritetag($tag->id))
        <form action="{{url('unfavoritetag/' . $tag->name)}}" method="POST">
            {{ csrf_field() }}
            <button style="float:right; padding:5px" type="submit" class="btn  btn-rounded shadow-none "><img style="display: inline; float:right; " type="submit" width="30px" height="30px" src="{{ asset('img/unfavorite.png')}}"></button>
        </form>
        @else
        <form action="{{url('favoritetag/' . $tag->name)}}" method="POST">
            {{ csrf_field() }}
            <button style="float:right; padding:5px" type="submit" class="btn  btn-rounded shadow-none "><img style="display: inline; float:right; " type="submit" width="30px" height="30px" src="{{ asset('img/favorite.png')}}"></button>
        </form>
        @endif
        @endif
    </div>
</li>
