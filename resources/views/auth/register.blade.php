@extends('layouts.app')

@section('content')
<div class="container">
  <div style="padding-top:150px"class="row">
      <div  class="col-md-6">
        <img src="{{ asset('img/logo.png') }}" width="550px" height="300px">
        <h1>lets Talk Science</h1> <h5>Where we mostly talk science</h5>
        <br><br><br><br>
      </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="py-3">
                  <h3 class="card-title">{{ __('Create an account') }}</h3>
                </div>
                  <p>Its quick and simple</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="md-form">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <label for="name" >{{ __('Name') }}</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="email" >{{ __('E-Mail Address') }}</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <input type="hidden" name="image" value="noimage.jpg">

                        <div class="md-form">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                                <label for="username" >{{ __('Username') }}</label>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="md-form">
                                <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" required autocomplete="dob">
                                <label for="dob" >{{ __('Date of Birth') }}</label>
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form">

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                <label for="password" >{{ __('Password') }}</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="md-form">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm" >{{ __('Confirm Password') }}</label>
                        </div>
                          <div class="md-form">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
