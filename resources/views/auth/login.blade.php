<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-90680653-2');
    </script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <!-- <meta name="twitter:site" content="@bootstrapdash">
    <meta name="twitter:creator" content="@bootstrapdash">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Azia">
    <meta name="twitter:description" content="Responsive Bootstrap 5 Dashboard Template">
    <meta name="twitter:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png"> -->

    <!-- Facebook -->
    <!-- <meta property="og:url" content="https://www.bootstrapdash.com/azia">
    <meta property="og:title" content="Azia">
    <meta property="og:description" content="Responsive Bootstrap 5 Dashboard Template">

    <meta property="og:image" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:secure_url" content="https://www.bootstrapdash.com/azia/img/azia-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600"> -->

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 5 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <title>Travocom - Lead Management - CRM - Beta Version</title>
    @include('layouts.css')


  </head>
  <body class="az-body" style="background: url(https://wallpaperaccess.com/full/706916.jpg) center center/cover no-repeat!important;">

    <div class="az-signin-wrapper">
        <div class="az-card-signin" style="background: rgba(255,255,255,1);">
        <h1 class="az-logo"> <img src="{{asset('img/logo.png')}}" style="height:170px;"></h1>
        <div class="az-signin-header">
          <h2>Welcome back!</h2>
          <h4>Please sign in to continue</h4>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input id="email"
                       class="form-control form-control-rounded"
                       name="email" value="{{ old('email') }}" required autocomplete="email"
                       autofocus>
                @error('email')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div><!-- form-group -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password"
                       class="form-control form-control-rounded"
                       name="password" required autocomplete="current-password">
                @error('password')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button class="btn btn-az-primary btn-block">Sign In</button>
            <button class="btn btn-az-primary btn-block">Unlock with PIN <i class="fa fa-briefcase"></i></button>
          </form>
        </div><!-- az-signin-header -->
<!--        <div class="az-signin-footer">
          <p><a href="">Forgot password?</a></p>
        </div> az-signin-footer -->
      </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->

    @include('layouts.script')
    <script>
      $(function(){
        'use strict'

      });
    </script>
  </body>
</html>
