@extends('login')

@section('content')
<header class="main-header" style="border-bottom:5px solid #f00; background-color: #0f0f2d">

    <a class="logo" style="color: white">
        <span class="logo-mini">D<b>R</b>M</span>
        <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="fas fa-align-justify"></span>
        </a>
    </nav>

</header>
<div class="login-box">
  <div class="login-logo">
    <b>Reset Password</b>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Enter your new password</p>

     <form method="POST" action="{{ route('password.update') }}">
        @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control login-text-field" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
          </span>
      @endif
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control login-text-field" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif
      <div class="form-group has-feedback">
        <input type="password" name="password_confirmation" class="form-control login-text-field" placeholder="Confirm Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      @if ($errors->has('password'))
          <span class="invalid-feedback" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
      @endif
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-block btn-flat login-button">Submit</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection