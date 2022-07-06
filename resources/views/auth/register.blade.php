{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.2/tailwind.min.css">
</head>

<body>

    <section class="flex flex-col md:flex-row h-screen items-center">

        <div class="bg-blue-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80"
                alt="" class="w-full h-full object-cover">
        </div>

        <div
            class="bg-white w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
              flex items-center justify-center">

            <div class="w-full h-100">

                <h1 class="text-xl font-bold">{{ env('APP_NAME') }}</h1>

                <h1 class="text-xl md:text-2xl font-bold leading-tight mt-12">Create new account</h1>

                <form class="mt-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label class="block text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter Your Name"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                            autofocus autocomplete value="{{ old('name') }}">
                    </div>

                    @error('name')
                        <small class="text-red-600" role="alert">
                            {{ $message }}
                        </small>
                    @enderror

                    <div class="mt-4">
                        <label class="block text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter Email Address"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                            autofocus autocomplete value="{{ old('email') }}">
                            @error('email')
                                <small class="text-red-600" role="alert">
                                    {{ $message }}
                                </small>
                            @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter Password" minlength="6"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500
                      focus:bg-white focus:outline-none"
                            >
                        @error('password')
                            <small class="text-red-600" role="alert">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password" placeholder="Enter Password" minlength="6"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500
                      focus:bg-white focus:outline-none"
                            >

                    </div>

                    <div class="text-right mt-2">
                        @if (Route::has('password.request'))

                                    <a href="{{ route('password.request') }}"
                            class="text-sm font-semibold text-gray-700 hover:text-blue-700 focus:text-blue-700">Forgot
                            Password?</a>
                                @endif
                    </div>

                    <button type="submit"
                        class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg
                    px-4 py-3 mt-6">Register</button>
                </form>

                <hr class="my-6 border-gray-300 w-full">

                <button type="button"
                    class="w-full block bg-white hover:bg-gray-100 focus:bg-gray-100 text-gray-900 font-semibold rounded-lg px-4 py-3 border border-gray-300">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            class="w-6 h-6" viewBox="0 0 48 48">
                            <defs>
                                <path id="a"
                                    d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                            </defs>
                            <clipPath id="b">
                                <use xlink:href="#a" overflow="visible" />
                            </clipPath>
                            <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                            <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                            <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                            <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                        </svg>
                        <span class="ml-4">
                            Log in
                            with
                            Google</span>
                    </div>
                </button>

                <p class="mt-8">Need an account? <a href="{{ route('login') }}"
                        class="text-blue-500 hover:text-blue-700 font-semibold">Login to your account</a></p>

                <p class="text-sm text-gray-500 mt-12">&copy; {{ date('Y') }} {{ env('APP_NAME') }} - All Rights Reserved.</p>
            </div>
        </div>

    </section>

</body>

</html>
