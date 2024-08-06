@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="vertical-align-wrap">
    <div class="vertical-align-middle">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-4">
                <div class="auth-box" style="height: auto !important;">
                    <div class="content">
                        <div class="header">
                            <div class="logo text-center">
                                <img src="{{ siteIcon('site_logo','site-logo.png') }}" alt="Logo">
                            </div>
                            <p class="lead">Login to your account</p>
                        </div>
                        @include('admin.messages')
                        <form class="form-auth-small" method="POST" action="{{ route('admin.auth.loginAdmin') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="signin-email" class="control-label sr-only">Email</label>
                                <input id="signin-email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="signin-password" class="control-label sr-only">Password</label>
                                <input id="signin-password" type="password" class="form-control" name="password" placeholder="Password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group clearfix">
                                <label class="fancy-checkbox element-left custom-bgcolor-blue">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="text-muted">Remember me</span>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                            <!-- <div class="bottom">
                                <span class="helper-text"><i class="fa fa-lock"></i> <a href="forgot-password.html">Forgot password?</a></span>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection