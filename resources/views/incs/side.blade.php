<div class="col-md-4">
    <li class="list-group-item">
        <h3>Trending</h3>
        <ul class="list-group list-group-flush">
            <?php $i=1; ?>
            @foreach($trendingtags as $trendingtag)
            <li style="padding:6px;" class="list-group-item">
                <a href="{{url('hashtag/' . $trendingtag->name)}}">
                    <h5>{{$i}}. #{{$trendingtag->name}}</h5>
                    <?php $i++;?>
                </a>
            </li>
            @endforeach
            <!-- @foreach($results as $result)
            {{$result->tag_id}},
            {{$result->cnt}}
            <br>
            @endforeach -->
        </ul>
    </li>
    <div class="py-2">
        <li class="list-group-item">
            <h3>Who to Follow</h3>
            <ul class="list-group list-group-flush">
                <li style="padding:6px;" class="list-group-item">
                    @if(!$suggestedusers==null)
                    @foreach($suggestedusers as $user)
                    @include('users/suggestedusercard')
                    @endforeach
                    @else
                    <p> Follow someone to get Suggestions</p>
                    @endif
                </li>
            </ul>
        </li>
    </div>
    <li class="list-group-item">
        <h3>topics of intrest</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                @if(!$suggestedtags==null)
                @foreach($suggestedtags as $tag)
            <li style="padding:6px;" class="list-group-item">
                <a href="{{url('hashtag/' . $tag->name)}}">
                    <h5>#{{$tag->name}}</h5>
                </a>
            </li>
            @endforeach
            @else
            <p> Follow someone to get Suggestions</p>
            @endif
    </li>
    </ul>
    </li>

    <div style="padding-left:10px">
        <br>
          <a href="#"><p style="color:grey; display: inline-block; "> About  LTS . </p> </a>
            <a href="#"><p style="color:grey; display: inline-block; "> Help . </p> </a>
            <a href="#"><p style="color:grey; display: inline-block; "> Contact LTS . </p> </a>
          <a href="#"><p style="color:grey; display: inline-block; "> Terms . </p> </a>
          <a href="#"><p style="color:grey; display: inline-block; "> Privacy</p> </a>
          <a href="#"><p style="color:grey;  ">© 2020 LTS</p> </a>



    </div>




</div>
