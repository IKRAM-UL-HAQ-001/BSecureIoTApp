@extends('layout')

@section('content')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="ipaddress" class="col-md-4 col-form-label text-md-right">IP Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="ipaddress" class="form-control" name="ipaddress" required autofocus>
                                    @if ($errors->has('ipaddress'))
                                        <span class="text-danger">{{ $errors->first('ipaddress') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="encodeAndSubmit()">
                                    Login
                                </button>
                            </div>
                        </form>
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('errors'))
                            <div class="alert alert-danger"  role="alert">
                                {{ session('errors') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 2000); 
</script>

<script>
    function encodeAndSubmit() {
        // Get user input values
        var emailElement = document.getElementById('email');
        var passwordElement = document.getElementById('password');
        var ipaddressElement = document.getElementById('ipaddress');

        // Base64 encode the values
        var encodedEmail = btoa(emailElement.value);        
        var encodedPassword = btoa(passwordElement.value);        
        var encodedIpaddress = btoa(ipaddressElement.value);

        // Update form values with encoded values
        emailElement.value = encodedEmail;
        passwordElement.value = encodedPassword;
        ipaddressElement.value = encodedIpaddress;

        // Submit the form
        document.querySelector('form').submit();
    }
</script>

@endsection
