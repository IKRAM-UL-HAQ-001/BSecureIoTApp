
@extends('layout')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register IoT Device') }}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('iotdevices.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Device Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="mac_address">MAC Address</label>
                                    <input type="text" name="mac_address" id="mac_address" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="ip_address">IP Address</label>
                                    <input type="text" name="ip_address" id="ip_address" class="form-control" required>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary" onclick="encodeAndSubmit()">
                                        Register IoT Device
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <script>
    function encodeAndSubmit() {
        // Get user input values
        var nameElement = document.getElementById('name');
        var mac_addressElement = document.getElementById('mac_address');
        var ip_addressElement = document.getElementById('ip_address');

        // Base64 encode the values
        var encoded_name = btoa(nameElement.value);        
        var encoded_mac_address = btoa(mac_addressElement.value);        
        var encoded_ip_address = btoa(ip_addressElement.value);

        // Update form values with encoded values
        nameElement.value = encoded_name;
        mac_addressElement.value = encoded_mac_address;
        ip_addressElement.value = encoded_ip_address;

        // Submit the form
        document.querySelector('form').submit();
    }
</script>
@endsection
