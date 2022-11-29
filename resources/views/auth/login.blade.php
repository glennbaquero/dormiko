@extends('login')

@section('content')
<header class="main-header" style="border-bottom:5px solid #f00; background-color: #0f0f2d">

    <a class="logo" style="color: white">
        <span class="logo-mini">D<b>R</b>M</span>
        <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        </a>
    </nav>

</header>

<div class="login-box">
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group has-feedback" style="width: 85%; margin: 0% auto">
            <input type="email" name="email"  class="form-control" placeholder="Email" style="border: 1px solid #000; border-radius: 0px" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback" style="width: 85%; margin: 2% auto">
            <input type="password" name="password" class="form-control" placeholder="Password" style="border: 1px solid #000; border-radius: 0px">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row" style="margin: 0% auto; margin-left: 4.3%; margin-right: 4.3%">
            <div class="col-md-4">
              <button type="submit" class="btn btn-block btn-flat" style="background-color: #12122f; color: white">Sign in</button>
            </div>
        </div>
    </form>
    <a href="{{ route('forgot.password') }}" style="padding: 36px">I forgot my password</a><br>
    </div>
</div>
 @endsection