<!-- user card shows individual user on pages like User followers, user following and search results.-->
<li class="list-group-item">
    <img style="display: inline; float:left;  border-radius:50%; " width="60px" height="60px" src="{{ asset('images/profile/'.$user->image)}}">
    <div style="padding-left:65px;">
        <a href="{{url($user->username)}}">
            <h5 style="float:left;  font-weight: 900;">{{$user->name}}</h5>
        </a>
        <p style="color:grey;float:left;">&nbsp@ </p>
        <p style="color:grey;">{{$user->username}}</p>
        <p>{{$user->bio}}</p>
        @if (!($user->id == Auth::id()))
        @if (Auth::User()->isFollowing($user->id))
        <form action="{{url('unfollow/' . $user->username)}}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button style="float:right;" type="submit" class="btn btn-outline-danger btn-rounded shadow-none" class="btn btn-danger">
                <i class="fa fa-btn fa-trash"></i>Unfollow
            </button>
        </form>
        @else
        <form action="{{url('follow/' . $user->username)}}" method="POST">
            {{ csrf_field() }}

            <button style="float:right;" type="submit" class="btn btn-outline-primary btn-rounded shadow-none ">Follow</button>
        </form>
        @endif
        @endif
    </div>
</li>
