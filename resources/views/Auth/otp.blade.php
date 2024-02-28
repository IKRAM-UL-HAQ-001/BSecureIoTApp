@extends('layout')
  
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">One Time Passcode</div>
                    <div class="card-body">
                        <form action="{{ route('otp.verify') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="otp" class="col-md-4 col-form-label text-md-right">OTP</label>
                                <div class="col-md-6">
                                    <input type="text" id="otp" class="form-control" name="otp" required autofocus>
                                    @if ($errors->has('otp'))
                                        <span class="text-danger">{{ $errors->first('otp') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    verify
                                </button>
                            </div>
                        </form>     
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('errors') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 2000); 
</script>