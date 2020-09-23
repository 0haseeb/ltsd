<!-- Shows indivitual comment (Such as Comments on individial post page) -->
<div class="card shadow-none">
    <li class="list-group-item">
        <img style="display: inline; float:left; border-radius:50%;" width="40px" height="40px" src="{{ asset('images/profile/'.$comment->user->image)}}">
        <div style=" float:right;" class="dropdown dropleft ">
            <div href="#" id="imageDropdown" data-toggle="dropdown">
                <img width="20px" height="20px" src="{{ asset('img/dropdown.png') }}">
            </div>
            <div class="dropdown-menu">
                <!--Comment Dropdown menu links -->
                <!--only let auth user delete comments-->
                @if($comment->user_id == Auth::id())
                <form action="{{action('PostController@destroycomment', $comment['id'])}}" method="post"> @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="dropdown-item" type="submit"><img src="{{ asset('img/delete.png') }}" width="30px" height="30px">&nbsp Delete</button>
                </form>
                @else
                <button class="dropdown-item" type="button"><img src="{{ asset('img/report.png') }}" width="30px" height="30px">&nbsp Report</button>
                @endif
            </div>
        </div>
        <br />
        <div style="padding-left:45px;">
            <a href="{{url($comment->user->username)}}">
                <h5 style="float:left; font-weight: 500;">{{$comment->user->name}}</h5>
            </a>
            <p style="color:grey;float:left;">&nbsp@</p>
            <p style="color:grey;">{{$comment->user->username}}</p>
            <p>{{$comment['comment']}} </p>
            <!-- <a style="color:purple;float:left;" href="{{ url('profile') }}">
        <h5>Like</h5>
    </a> -->
            <small style="color:grey;"><?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans() ?> </small>
        </div>
    </li>
</div>
