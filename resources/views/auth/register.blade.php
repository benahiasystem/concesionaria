@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col s12 m6 offset-m3"> 
        <div class="card">
                <div class="card-action teal lighten-1 white-text">
                        <h3>Registrar</h3> 
                    </div><br>
            <form method="POST" action="{{ route('register') }}">
                            @csrf
            <div class="card-content">
                    <div class="input-field col s12">   
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        <label for="name">{{ __('Nombre') }}</label>
    
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                    </div>
              
            
                    <div class="input-field col s12">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        <label for="email">{{ __('email') }}</label>

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="input-field col s12">
                            <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                    </div>
                    
                    <div class="input-field col s12">
                            <label for="confirm-password">{{ __('Password_confirm') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="form-field">
                            <button class="btn waves-effect waves-light right" type="submit" name="action">Register
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    
                    
                    <br><b><br><br><br><b><br><br><br><b><br><br><br><b><br><br>
                        <b><br><br><br><b><br><br>
            </form>
            </div>
        </div>
    </div>

</div>

@endsection
