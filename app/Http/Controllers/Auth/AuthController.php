<?php  
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\Cache;
use Session;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;
use App\Models\registrationtime;
use App\Models\logintime;
use App\Models\otptime;
use Hash;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\BlockedIp;
use App\Models\LoginAttempt;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function otp()
    {
        return view('auth.otp');
    }  
      
    public function registration()
    {
        return view('auth.registration');
    }
    
    public function postRegistration(Request $request)
    {  
        $start_time1=carbon::now();
        $start_time = $start_time1->format('H:i:s') . '.' . sprintf("%06d", $start_time1->micro);
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'haddress' => 'required',
            'ipaddress' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:1',
        ]);           
        $data = $request->all();

        $user = User::create([
            'name' => ($data['name']),
            'email' => ($data['email']),
            'phone' => ($data['phone']),
            'ipaddress' => ($data['ipaddress']),
            'haddress' => ($data['haddress']),
            'password' => ($data['password']),
        ]);
        $end_time1=carbon::now();
        $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
        
        $registrationtime = new registrationtime();
        $registrationtime->user_id= $user->id;
        $registrationtime->start_time = $start_time;
        $registrationtime->end_time = $end_time;
        $registrationtime->ipaddress = $request->ipaddress;
        $registrationtime->save();
        return redirect("/")->withSuccess('You have Successfully registered');
    }

    public function postLogin(Request $request)
    {
        $start_time1 = Carbon::now();
        $start_time = $start_time1->format('H:i:s') . '.' . sprintf("%06d", $start_time1->micro);
        $request->validate([
            'email' => 'required',
            'ipaddress' => 'required',
            'password' => 'required',
        ]);
        $ipAddress = $request->ipaddress;
        $password = $request->password;
        $email = $request->email;
        $blockedIp = BlockedIp::where('ipaddress', $ipAddress)->first();

        if ($blockedIp && $blockedIp->is_blocked) {
            $end_time1 = Carbon::now();
            $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
            $logintime = new logintime();
            $logintime->start_time = $start_time;
            $logintime->end_time = $end_time;
            $logintime->ipaddress = $request->ipaddress;
            $logintime->save();
            return redirect("/")->withSuccess('Your IP address is blocked. Please contact support.');
        } else {
            $user = User::where('email', $email)->first();

            if ($user && Hash::check($password, $user->password)) {
                if (Auth::attempt(['ipaddress' => $ipAddress, 'password' => $password, 'email' => $email], true, true)) {
                    if ($blockedIp) {
                        $blockedIp->update([
                            'attempts' => 0,
                            'blocked_until' => null,
                        ]);
                    }
                    $google2fa = new Google2FA();
                    $google2fa_secret = $google2fa->generateSecretKey();
                    $user->google2fa_secret = $google2fa_secret;                    
                    $subject = 'BSecure Application OTP';
                    $user->save();
                    $encodedemail = auth()->user()->email;
                    $sendemail = base64_decode($encodedemail);
                    Mail::to($sendemail)->send(new SendEmail($subject, $google2fa_secret));
                    $end_time1=carbon::now();
                    $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
                    $logintime = new logintime();
                    $logintime->start_time = $start_time;
                    $logintime->end_time = $end_time;
                    $logintime->ipaddress = $request->ipaddress;
                    $logintime->save();
                    return redirect("otp")->withSuccess('Please Enter OTP');
                } else {
                    // Log invalid login attempt
                    if ($blockedIp) {
                        $blockedIp->increment('attempts');
                        if ($blockedIp->attempts >= 3) {
                            $lastAttemptTime = $blockedIp->updated_at;
                            $twoMinutesAgo = now()->subMinutes(2);
                            if ($lastAttemptTime >= $twoMinutesAgo) {
                                $blockedIp->update([
                                    'is_blocked' => true,
                                ]);
                                // Log login time
                                return redirect("/")->withSuccess('Your IP address is blocked');
                            }
                        } else {
                            if ($blockedIp->attempts == 3) {
                                $blockedIp->update([
                                    'blocked_until' => now()->addMinutes(2),
                                ]);
                            }
                        }
                    } else {
                        BlockedIp::create([
                            'ipaddress' => $ipAddress,
                            'attempts' => 1,
                        ]);
                    }
                    // Log login time
                    return redirect("/")->withSuccess('Oops! You have entered invalid credentials');
                }
            } else {
                // Log invalid email or password attempt
                if ($blockedIp) {
                    $blockedIp->increment('attempts');
                    if ($blockedIp->attempts >= 3) {
                        $lastAttemptTime = $blockedIp->updated_at;
                        $twoMinutesAgo = now()->subMinutes(2);
                        if ($lastAttemptTime >= $twoMinutesAgo) {
                            $blockedIp->update([
                                'is_blocked' => true,
                            ]);
                            // Log login time
                            return redirect("/")->withSuccess('Your IP address is blocked');
                        }
                    } else {
                        if ($blockedIp->attempts == 3) {
                            $blockedIp->update([
                                'blocked_until' => now()->addMinutes(2),
                            ]);
                        }
                    }
                } else {
                    BlockedIp::create([
                        'ipaddress' => $ipAddress,
                        'attempts' => 1,
                    ]);
                }
                // Log login time
                return redirect("/")->withSuccess('Invalid Credentials');
            }
        }
    }

    public function verifyOTP(Request $request)
    {
        $start_time1=carbon::now();
        $start_time = $start_time1->format('H:i:s') . '.' . sprintf("%06d", $start_time1->micro);
        $user = Auth::user(); 
        $otpInput = $request->input('otp');
        $ipAddress = $request->ip();
        $blockedIp = BlockedIp::where('ipaddress', $ipAddress)->first();
        if ($blockedIp && $blockedIp->is_blocked) {
            $end_time1=carbon::now();
            $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
            $otptime = new otptime();
            $otptime->start_time = $start_time;
            $otptime->end_time = $end_time;
            // $otptime->user_id = $user;
            $otptime->save();
            return redirect("/")->withSuccess('Your IP address is blocked. Please contact support.');
        } else {
            $google2fa = new Google2FA();
            $secret = $user->google2fa_secret; // Retrieve the secret key from the user

            if ($otpInput == $secret) {
                $securityToken = $this->generateRecoveryCode(); // Implement this function
                $user->security_token = $securityToken;
                $user->save();
                if ($blockedIp) {
                    $blockedIp->update([
                        'attempts' => 0,
                        'blocked_until' => null,
                    ]);
                }
                $end_time1=carbon::now();
                $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
                $otptime = new otptime();
                $otptime->start_time = $start_time;
                $otptime->end_time = $end_time;
                // $otptime->user_id = $user;
                $otptime->save();
                return redirect("dashboard")->withSuccess('OTP verified.');
            } else {
                if ($blockedIp) {
                    $blockedIp->increment('attempts');
                    if ($blockedIp->attempts >= 3) {
                        // Check if the last OTP attempt was more than 3 minutes ago
                        $lastAttemptTime = $blockedIp->updated_at;
                        $threeMinutesAgo = now()->subMinutes(3);
                        if ($lastAttemptTime <= $threeMinutesAgo) {
                            // Reset the attempts count if the last attempt was more than 3 minutes ago
                            $blockedIp->update([
                                'attempts' => 1,
                            ]);
                        } else {
                            $blockedIp->update([
                                'is_blocked' => true,
                                // 'blocked_until' => now()->addMinutes(3),
                            ]);
                            $end_time1=carbon::now();
                            $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
                            $otptime = new otptime();
                            $otptime->start_time = $start_time;
                            $otptime->end_time = $end_time;
                            // $otptime->user_id = $user;
                            $otptime->save();
                            return redirect("/")->withSuccess('Your IP address is blocked.');
                        }
                    }
                } else {
                    BlockedIp::create([
                        'ipaddress' => $ipAddress,
                        'attempts' => 1,
                    ]);
                }
                $end_time1=carbon::now();
                $end_time = $end_time1->format('H:i:s') . '.' . sprintf("%06d", $end_time1->micro);
                $logintime = new otptime();
                $logintime->start_time = $start_time;
                $logintime->end_time = $end_time;
                // $otptime->user_id = $user;
                $logintime->save();
                return redirect("otp")->withSuccess('Oops! You have entered an invalid OTP');
            }
        }
    }           
    
    public function dashboard()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect("/")->withSuccess('Oops! You do not have access');
        }
        $devices = $user->iotDevices;
        return view('dashboard', compact('devices'));
    }

    public function logout() 
    {
         $user = Auth::user();
        if ($user) {
            $user->security_token = null; // Clear the recovery code
            $user->save();
        }
        Session::flush();
        Auth::logout();
  
        return Redirect("/");
    }
       
    public function generateRecoveryCode()
    {
        $randomString = Str::random(16); // Generate a random 16-character string
        $securityToken = hash('sha256', $randomString); // Generate a random 16-character code
        return $securityToken;
    }

    public function storeRecoveryCode(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        if ($user) {
            $securityToken = $this->generatesecurityToken();
            $user->security_token = $securityToken;
            $user->save();

            return redirect()->intended('dashboard')->withSuccess('Recovery code generated: ' . $securityToken);
        } else {
            return redirect()->back()->withError('User not found.');
        }
    }
    
}