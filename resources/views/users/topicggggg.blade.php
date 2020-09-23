@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ url()->previous() }}"> <img style="float:left;" src="{{ asset('img/back.png') }}" width="30px" height="30px" alt=""> </a>


                    @foreach($userss as $user)
                    @include('users/usercard')
                    @endforeach
                </li>


            </ul>
        </div>
        @include('incs/side')
    </div>
</div>
@endsection
