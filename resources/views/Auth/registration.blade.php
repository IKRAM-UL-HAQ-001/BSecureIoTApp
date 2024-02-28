@extends('layout')
  
@section('content')
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control" name="name" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                                <div class="col-md-6">
                                    <input type="text" id="phone" class="form-control" name="phone" required autofocus>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="haddress" class="col-md-4 col-form-label text-md-right">Home Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="haddress" class="form-control" name="haddress" required autofocus>
                                    @if ($errors->has('haddress'))
                                        <span class="text-danger">{{ $errors->first('haddress') }}</span>
                                    @endif
                                </div>
                            </div>
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
                                <button type="submit" class="btn btn-primary" onclick="encodeAndSubmit()">
                                    Register
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
        var nameElement = document.getElementById('name');
        var emailElement = document.getElementById('email');
        var phoneElement = document.getElementById('phone');
        var passwordElement = document.getElementById('password');
        var ipaddressElement = document.getElementById('ipaddress');
        var haddressElement = document.getElementById('haddress');

        // Base64 encode the values
        var encodedName = btoa(nameElement.value);
        var encodedEmail = btoa(emailElement.value);
        var encodedPhone = btoa(phoneElement.value);
        var encodedIpaddress = btoa(ipaddressElement.value);
        var encodedHaddress = btoa(haddressElement.value);        
        var encodedPassword = btoa(passwordElement.value);


        // Update form values with encoded values
        nameElement.value = encodedName;
        phoneElement.value = encodedPhone;
        haddressElement.value = encodedHaddress;
        emailElement.value = encodedEmail;
        passwordElement.value = encodedPassword;
        ipaddressElement.value = encodedIpaddress;

        // Submit the form
        document.querySelector('form').submit();
    }
</script>
@endsection