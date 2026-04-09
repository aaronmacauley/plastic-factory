
@extends('layouts.master-without-nav')
@section('title') Login @endsection
@section('body') <body> @endsection
    @section('content')

    <div class="home-btn d-none d-sm-block">
        <a href="index" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50">Sign in to continue to Veltrix.</p>
                                <a href="index" class="logo logo-admin">
                                    <img src="{{URL::asset('assets/images/logo-sm.png')}}" height="24" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                                <form method="POST" action="{{ route('login') }}" class="mt-4">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="admin@themesbrand.com" required autocomplete="email" value="admin@themesbrand.com" autofocus placeholder="Enter Email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">{{ __('Password') }} <span class="text-danger">*</span></label>
                                        <input id="password" type="password" value="12345678" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-end">
                                            <button type="submit" class="btn btn-primary w-md waves-effect waves-light">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-2 mb-0 row">
                                        <div class="col-12 mt-4">
                                            @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}"><i class="mdi mdi-lock"></i>
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                            @endif
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <p>Don't have an account ? <a href="{{ route('register') }}" class="fw-medium text-primary"> Signup now </a> </p>
                        <p class="mb-0">© <script>
                                document.write(new Date().getFullYear())

                            </script> Veltrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
    
    <script src="{{URL::asset('assets/js/app.js')}}"></script>

    @endsection
