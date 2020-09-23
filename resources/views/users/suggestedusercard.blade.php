<!-- Suggested User card - shows Suggested Users to follow on side bar-->
<li class="list-group-item">
    <img style="display: inline; float:left;  border-radius:50%; " width="60px" height="60px" src="{{ asset('images/profile/'.$user->image)}}">
    <form action="{{url('follow/' . $user->username)}}" method="POST">
        {{ csrf_field() }}
        <button style="float:right;border-radius:30px; font-size: 14px; padding:4px 8px;" type="submit" class="btn btn-outline-primary btn-rounded shadow-none ">Follow</button>
    </form>
    <div style="padding-left:65px;">
        <a href="{{url($user->username)}}"><h5 style="font-weight: 900;">{{$user->name}}</h5></a>
        <p style="color:grey;float:left;">&nbsp@ </p>
        <p style="color:grey;">{{$user->username}}</p>

    </div>
</li>
