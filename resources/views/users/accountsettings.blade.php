<!-- "Page" Shows user Account settings  options -->
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <ul class="list-group">
                <li class="list-group-item">
                    <h3> <b>Settings</b></h3>
                </li>
                <a href="{{url('settings/account')}}">
                    <li class="list-group-item">
                        <h4> Account</h4>
                    </li>
                </a>
                <a href="{{url('settings/security')}}">
                    <li class="list-group-item">
                        <h4> Security</h4>
                    </li>
                </a>
            </ul>
        </div>
        <div class="col-md-8">
            <!-- display the errors -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul> @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li> @endforeach
                </ul>

            </div><br />
            @endif
            <!-- display the success status -->
            @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
                {{header("Refresh:2")}}
            </div>
            @endif
            <ul class="list-group">
                <li class="list-group-item">
                    <h3> <b>Account</b></h3>
                </li>
                <li class="list-group-item">
                    <h4> Email</h4>
                    <form method="POST" action="{{action('ProfileController@updateAccountSettings', 'updateAccountSettings')}}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="md-form">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{Auth::user()->email}}" required autocomplete="email">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <button style="float:right;border-radius:30px; font-size: 14px; padding:4px 8px;" type="submit" class="btn btn-outline-primary ">Update</button>
                        </div>
                    </form>
                </li>
                <li class="list-group-item">
                    <h4> Username</h4>
                    <form method="POST" action="{{action('ProfileController@updateAccountSettings', 'updateAccountSettings')}}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="md-form">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="{{Auth::user()->username}}" required autocomplete="username">
                            <label for="username">{{ __('Username') }}</label>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <button style="float:right;border-radius:30px; font-size: 14px; padding:4px 8px;" type="submit" class="btn btn-outline-primary ">Update</button>
                        </div>
                    </form>
                </li>
                <li class="list-group-item">
                    <h4> Date of birth</h4>
                    <form method="POST" action="{{action('ProfileController@updateAccountSettings', 'updateAccountSettings')}}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="md-form">
                            <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" placeholder="{{Auth::user()->dob}}" required autocomplete="dob">
                            <label for="dob">{{ __('Date of Birth') }}</label>
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <button style="float:right;border-radius:30px; font-size: 14px; padding:4px 8px;" type="submit" class="btn btn-outline-primary ">Update</button>
                        </div>
                    </form>
                </li>
                <br>
                <li class="list-group-item">
                    <h3> <b>Delete Account</b></h3>
                </li>

                <li class="list-group-item">
                    <h4> Account cannot be recoverd once deleted.</h4>
                    <p>All posts, followers, comments, like and anything associated with the account will be deleted.</p>
                    <p>Please enter your password to continue</p>
                    <form action="{{action('ProfileController@destroy')}}" method="post"> @csrf
                        <div class="md-form">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <label for="password">{{ __('Password') }}</label>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="md-form">
                            <input name="_method" type="hidden" value="DELETE">
                            <button style="float:right;border-radius:30px; font-size: 14px; padding:4px 8px;" type="submit" class="btn btn-outline-danger ">Delete</button>
                        </div>
                    </form>
                </li>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
