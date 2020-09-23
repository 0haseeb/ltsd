<!-- "Page" Shows user Security settings  options -->
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
                    <h3> <b>Security</b></h3>
                </li>
                <li class="list-group-item">
                    <h4> Password</h4>
                    <form method="POST" action="{{action('ProfileController@updateSecuritySettings', 'updateSecuritySettings')}}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="md-form">
                                <input id="oldpassword" type="password" class="form-control @error('oldpassword') is-invalid @enderror" name="oldpassword" required autocomplete="oldpassword">
                                <label for="oldpassword" >{{ __('Current Password') }}</label>
                                @error('oldpassword')
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
                            <button style="float:right;border-radius:30px; font-size: 14px; padding:4px 8px;" type="submit" class="btn btn-outline-primary ">Update</button>
                            </div>
                    </form>
                </li>

                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
