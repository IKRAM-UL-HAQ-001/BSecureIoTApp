@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('My IoT Devices') }}
                </div>
                <div class="card-body">
                    @if (count($devices) > 0)
                        <a href="{{ route('iotdevices.create') }}" class="btn btn-primary">Add New Device</a>
                        <table id="iotDevicesTable" class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>IP Address</th>
                                    <th>MAC Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($devices as $device)
                                    <tr>
                                        <td>{{ base64_decode($device->name) }}</td>
                                        <td>{{ base64_decode($device->ip_address) }}</td>
                                        <td>{{ base64_decode($device->mac_address) }}</td>
                                        <td>
                                            <form method="post" action="{{ route('directIoT.send') }}">
                                                @csrf
                                                <input type="hidden" name="ipaddress" id="ipaddress" value="{{ $device->ip_address }}">
                                                <input type="hidden" name="id" id="id" value="{{ $device->id }}">
                                                <input type="submit" class="btn btn-primary" value="Direct Verification">
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="{{ route('blockchain.send') }}">
                                                @csrf
                                                <input type="hidden" name="ipaddress" id="ipaddress" value="{{ $device->ip_address }}">
                                                <input type="hidden" name="id" id="id" value="{{ $device->id }}">
                                                <button type="submit" class="btn btn-primary">Blockchain Based Verification</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No devices registered</p>
                         <a href="{{ route('iotdevices.create') }}">Add New Device</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#iotDevicesTable').DataTable();
    });
</script>
@endsection
