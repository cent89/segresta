@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5" style="margin-bottom: 30px;">
        <div class="card">
            <div class="card-body" style="text-align: center">
              <h2>Accedi con:</h2>
              <a href="{{ url('/auth/google/redirect') }}" class="btn btn-primary btn-lg" style="width: 50%; background-color: #e0472d; border-color: #e0472d"><i class="fab fa-google"></i> Google</a><br>
              <a href="{{ url('/auth/facebook/redirect') }}" class="btn btn-primary btn-lg" style="width: 50%; background-color: #3b5998; border-color: #3b5998; margin-top: 10px;"><i class="fab fa-facebook-f"></i> Facebook</a>
            </div>
          </div>
      </div>

        <div class="col-md-5">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Indirizzo Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Ricordami
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Hai dimenticato la password?
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div  style="text-align: center; margin-top: 20px;">
                          <h3><i class="fas fa-angle-double-right"></i> Non hai ancora un account? <a href="{{ route('register') }}">Registrati!</a> </h3>
                          </div>




                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
