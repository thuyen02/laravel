@extends('front.layouts.auth')

@section('content')
<div class="container-xl px-4">
    <div class="container">
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{    (Session::get('success')) }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            {{    (Session::get('error')) }}
        </div>
        @endif
    </div>
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
            <div class="card my-5">
                <div class="card-body p-5 text-center">
                    <div class="h3 fw-light mb-3">Sign In</div>
                    <!-- BEGIN: Social Login Links-->
                    <a class="btn btn-icon btn-facebook mx-1" href="#"><i class="fab fa-facebook-f fa-fw fa-sm"></i></a>
                    <a class="btn btn-icon btn-github mx-1" href="#"><i class="fab fa-github fa-fw fa-sm"></i></a>
                    <a class="btn btn-icon btn-google mx-1" href="#"><i class="fab fa-google fa-fw fa-sm"></i></a>
                    <a class="btn btn-icon btn-twitter mx-1" href="#"><i class="fab fa-twitter fa-fw fa-sm text-white"></i></a>
                    <!-- END: Social Login Links-->
                </div>
                <hr class="my-0" />
                <div class="card-body p-5">
                    <!-- BEGIN: Login Form-->
                    <form action="{{ route('account.authenticate') }}" method="POST">
                        @csrf
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="text-gray-600 small" for="input_type">Email / Username</label>
                            <input type="email" value="{{ old('email') }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                        </div>
                        <!-- Form Group (password)-->
                        <div class="mb-3">
                            <label class="text-gray-600 small" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Form Group (forgot password link)-->
                        <div class="mb-3"><a class="small" href="#">Forgot your password?</a></div>
                        <!-- Form Group (login box)-->
                        <div class="d-flex align-items-center justify-content-between mb-0">
                            <div class="form-check">
                                <input class="form-check-input" id="remember_me" name="remember" type="checkbox" />
                                <label class="form-check-label" for="remember_me">Remember me.</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    <!-- END: Login Form-->
                </div>
                <hr class="my-0" />
                <div class="card-body px-5 py-4">
                    <div class="small text-center">
                        New user?
                        <a href="{{ route('account.register') }}">Create an account!</a>
                    </div>
                </div>
            </div>
            <!-- END: Social Login Form-->
        </div>
    </div>
</div>
@endsection
