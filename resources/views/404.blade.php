<!-- Error:404-content not found page -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div style="text-align:center;">
                <br><br><br>
                <h1>404 not found</h1>
                <br><br><br><br>
                <a href="{{ url("home") }}"><u>
                        <h4>Return home</h4>
                    </u></a>
            </div>
        </div>
    </div>
</div>
@endsection
