@extends('layouts.app')

@section('content')



{{--<div class="form-group row mb-0"> codigo de olvidó contraseña
    <div class="col-md-8 offset-md-4">

        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif 
    </div>
</div>--}}


<div class="row">
    <div class="col s12 m4 offset-m4"> 
        <div class="card">
            <div class="card-action teal lighten-1 white-text">
                <h3>Login</h3> 
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
            <div class="card-content">
                <div class="input-field col s12">      
                    <input type="email" id="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required autofocus>
                    <label for="username">{{ __('E-Mail Address') }}</label>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                </div><br>
              
                <div class="input-field col s12">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                </div>

                <div class="form-field">
                        <label>
                                <input type="checkbox" name="remember" id="remember">
                                <span>Recordarme</span>
                              </label>
                </div><br>

                <div class="form-field">
                    <button class="btn waves-effect waves-light right" type="submit" name="action">Login
                        <i class="material-icons right">send</i>
                    </button>
                </div><br>

            </div>
            </form>
        </div>
    </div>

</div>

@endsection
