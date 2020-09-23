<!-- Shows indivitual Post (Such as post on homepage, profile page, topics page) -->
<div class="card shadow-none">
    <li class="list-group-item">
        <img style="display: inline; float:left;  border-radius:50%; " width="75px" height="75px" src="{{ asset('images/profile/'.$post->user->image)}}">
        <div style=" float:right;" class="dropdown dropleft ">
            <div href="#" id="imageDropdown" data-toggle="dropdown">
                <img width="20px" height="20px" src="{{ asset('img/dropdown.png') }}">
            </div>
            <div class="dropdown-menu">
                <!-- Dropdown menu links -->
                @if($post->user_id == Auth::id())
                <button class="dropdown-item" type="button" data-postid="{{$post['id']}}" data-toggle="modal" data-target="#editModal" data-postbody="{{$post['content']}} " ><img src="{{ asset('img/edit.png') }}" width="30px"
                      height="30px">&nbspEdit</button>
                <button class="dropdown-item" type="button" data-postid="{{$post['id']}}" data-toggle="modal" data-target="#deleteModal" ><img src="{{ asset('img/delete.png') }}" width="30px" height="30px">&nbsp Delete</button>
                @else
                <button class="dropdown-item" type="button"><img src="{{ asset('img/report.png') }}" width="30px" height="30px">&nbsp Report</button>
                @endif
            </div>
        </div>
        <div style="padding-left:90px;">
            <a href="{{url($post->user->username)}}">
                <h4 style=" font-weight: 900;">{{$post->user->name}}</h4>
            </a>
            <h5 style="color:grey;float:left;">@ </h5>
            <h5 style="color:grey;">{{$post->user->username}}&nbsp.&nbsp{{$post->created_at->diffForHumans()}}</h5>
            <br><br>
        </div>
        <div style="padding-left:15px;">
            <?php
                // Replace #hashtages with clicable links
                $post->content = preg_replace('/(?:^|\s)#(\w+)/', ' <a href="/lts/public/hashtag/$1">#$1</a>', $post->content);
            ?>
            <h4>{!!$post['content']!!} </h4>
            @if($post->image === Null)
            @else
            <img style="width:100%;height:100%; border-radius:20px;" src="{{ asset('images/post/'.$post->image)}}">
            @endif
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
            </li>
            <li class="list-group-item">
                <div style="padding-left:15px;">
                    <h5 style="float:left;">{{$post->likes->count()}} likes</h5>
                    <h5>&nbsp &nbsp &nbsp {{$post->comments->count()}} Comments</h5>
                </div>
            </li>
            <br>
            <div style="padding-left:30px;">
                <a href="{{action('PostController@show', $post['id'])}}"><img src="{{ asset('img/comment.png') }}" width="30px" height="30px"></a>
                @if (Auth::User()->hasliked($post->id))
                <a href="{{action('PostController@unlike', $post['id'])}}" style="padding-left:30px;"><img src="{{ asset('img/unlike.png') }}" width="30px" height="30px"></a>
                @else
                <a href="{{action('PostController@like', $post['id'])}}"  id="save"  style="padding-left:30px;"><img src="{{ asset('img/like.png') }}" width="30px" height="30px"></a>
                @endif
                <a  style="padding-left:30px;" data-container="body" data-toggle="popover" data-placement="top" data-content="{{url('posts/' . $post->id)}}"><img src="{{ asset('img/share.png') }}" width="30px" height="30px"></a>
                <!-- <a style="float:right;" href="{{ url('google.com') }}"><img src="{{ asset('img/save.png') }}" width="30px" height="30px"></a> -->
            </div>
        </ul>
    </li>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{action('PostController@update', 'edit_post')}}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="post_id" name="post_id" value="">
                    <textarea class="form-control" name="content" id="content" rows="5" style=" font-size: 18px; padding: 10px; resize: none ;overflow: hidden;  border: none;-webkit-box-shadow: none;"></textarea>
                </div>
                <div class="modal-footer">
                  <!-- uncomment this if website allows changing image on posts.  -->
                    <!-- <div style="float:left;" class="image-upload">
                        <label for="file-input">
                            <img width="50px" height="50px" src="{{ asset('img/image.png') }}" />
                        </label>
                        <input style="display:none;" id="file-input" type="file" name="image" />
                    </div> -->
                    <div class="md-form">
                        <button type="button" class="btn aqua-gradient" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn purple-gradient">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="color:red " class="modal-title" id="exampleModalCenterTitle">Delete post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{action('PostController@destroy','delete_post')}}" method="post"> @csrf
                <div class="modal-body">
                    <input type="hidden" id="post_id" name="post_id" value="">
                    <input name="_method" type="hidden" value="DELETE">
                    <p style=" text-align:center;">This action cannot be undone and post will be permanently remove from your account, newsfeed, other people who follow you and search results. Are you sure you want to Delete this post? </p>
                </div>
                <div class="modal-footer">
                    <div class="md-form">
                        <button type="button" class="btn aqua-gradient" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn peach-gradient">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
