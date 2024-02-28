<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\IoTDevice;
use App\Models\devicetime;
use App\Models\deviceregistrationtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IoTDeviceController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('iotdevices.create');
    }
    public function iotWorking()
    {
        return view('iotdevices.working');
    }

    public function updateSpeed(Request $request)
    {
        $userId = auth()->user()->id;

        $speedDirection = $request->input('direction');
        $iotDeviceId = $request->input('iotid');
        $requestedSpeed = $request->input('speed');

        $iotDevice = IoTDevice::where('id', $iotDeviceId)->first();

        if (!$iotDevice) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        if ($speedDirection === 'up') {
            $requestedSpeed++;
        } elseif ($speedDirection === 'down' && $requestedSpeed > 0) {
            $requestedSpeed--;
        }

        $minSpeed = 0;
        $maxSpeed = 100;
        
        $adjustedSpeed = max($minSpeed, min($requestedSpeed, $maxSpeed));

        $iotDevice->speed = $adjustedSpeed;
        $iotDevice->save();

        return view('iotdevices.working', ['iotid' => $iotDeviceId, 'speed' => $adjustedSpeed]);
    }

    
    public function store(Request $request)
    {
        $start_time1=carbon::now();
        $start_time = $start_time1->format('H:i:s') . '.' . sprintf("%06d", $start_time1->micro);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'ip_address' => 'required',
            'mac_address' => 'required',
        ]);
        $userId = auth()->user()->id;
        $device = new IoTDevice();
        $device->user_id = $userId;
        $device->name = $validatedData['name'];
        $device->ip_address = $validatedData['ip_address'];
        $device->mac_address = $validatedData['mac_address'];
        $device->save();

        $end_time1=carbon::now();
        $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
        $registrationtime = new deviceregistrationtime();
        $registrationtime->user_id= $userId;
        $registrationtime->start_time = $start_time;
        $registrationtime->end_time = $end_time;
        $registrationtime->ipaddress = $validatedData['ip_address'];
        $registrationtime->save();
        return redirect('dashboard')->with('success', 'IoT device registered successfully')->with('devices', $device);
    }

    public function show(IoTDevice $ioTDevice)
    {
        //
    }

    public function edit(IoTDevice $ioTDevice)
    {
        //
    }

    public function update(Request $request, IoTDevice $ioTDevice)
    {
        //
    }

    public function destroy(IoTDevice $ioTDevice)
    {
        //
    }
    
    public function directIoT(Request $request)
    {
        try {            
            $start_time=carbon::now();
            $userId = auth()->user()->id;
            $securityCode = auth()->user()->security_token;
            $ip_address = $request->ipaddress;
            $iotid = $request->id;
            $response = Http::post('http://10.120.87.21:8001/api/directIoT', [
            // $response = Http::post('http://192.168.0.104:8001/api/directIoT', [ 
                '_token' => csrf_token(),
                'user_id' => $userId,
                'security_data' => $securityCode,
                'ip_address' => $ip_address,
            ]);
            if ($response) {
                $data = $response->json(); 
                $message = $data['message']; 
                if($message=="IoT device is associated with this user"){
                    $iotDevice = IoTDevice::where('user_id', $userId)
                    ->where('id', $iotid)
                    ->first();
                    if ($iotDevice) {
                        $speed = $iotDevice->speed;
                    }
                    $end_time=carbon::now();
                    $userId = auth()->user()->id;
                    $device = new devicetime();
                    $device->user_id = $userId;
                    $device->start_time = $start_time;
                    $device->end_time = $end_time;
                    $device->ipaddress = $request->ipaddress;
                    $device->save();
                    return view('iotdevices.working', ['iotid' => $iotid, 'speed' => $speed]);
                }else{
                    $end_time=carbon::now();
                    $userId = auth()->user()->id;
                    $device = new devicetime();
                    $device->user_id = $userId;
                    $device->start_time = $start_time;
                    $device->end_time = $end_time;
                    $device->ipaddress = $request->ipaddress;
                    $device->save();
                    return $message;
                }
            } else {
                $end_time=carbon::now();
                $userId = auth()->user()->id;
                $device = new devicetime();
                $device->user_id = $userId;
                $device->start_time = $start_time;
                $device->end_time = $end_time;
                $device->ipaddress = $request->ipaddress;
                $device->save();
                return "Failed to send data. Error: " . $response->status();
            }
        } catch (\Exception $e) {
            return "Failed to send data. Exception: " . $e->getMessage();
        }

    }

    public function blockchain(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $securityCode = auth()->user()->security_token;
            $ip_address = $request->ipaddress;

            $response = Http::post('http://10.120.87.21:8001/api/blockchainIoT', [
                '_token' => csrf_token(),
                'user_id' => $userId,
                'security_data' => $securityCode,
                'ip_address' => $ip_address,
            ]);
            if ($response) {
                $data = $response->json(); // Parse the JSON response
                $message = $data['message'];
                return $message;
            } else {
                return "Failed to send data. Error: " . $response->status();
            }
        } catch (\Exception $e) {
            return "Failed to send data. Exception: " . $e->getMessage();
        }
    }

}
