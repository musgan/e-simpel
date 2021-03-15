@extends('layouts.app2')

@section('css')
<style type="text/css">
  .bg-login-image{
    background : url('{{asset("assets/img/logo.jpeg")}}');
    background-position: center;
    background-size: cover;
  }
  .bg-gradient-primary{
    background: url('{{asset("assets/img/bg_image2.jpeg")}}');
    background-position: center;
    background-size: cover;
  }
</style>
@endsection

@section('content')
<div class="container" style="">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Sistem Manajemen Data Pelaporan (E-Simpel)</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                   <!--  <div class="form-group">
                      {!! Form::select('user_levels', $user_levels, null, ['class' => 'form-control']); !!}
                    </div>
                    <div class="form-group">
                      {!! Form::select('sectors', $sectors, null, ['class' => 'form-control']); !!}
                    </div> -->
					<div class="form-group">
						<input id="email" type="email" class="form-control form-control-user" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email Address...">
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
                    <div class="form-group">
						<input id="password" type="password" placeholder="Password" class="form-control form-control-user" name="password" required>
						@if ($errors->has('password'))
							<span class="help-block">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
					</div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
					<button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                    
                  </form>
                  <hr>
                  <!-- 
                    dikosongkan sementara
                   -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

 </div>

@endsection
