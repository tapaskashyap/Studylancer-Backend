<?php

namespace App\Http\Controllers\Apis\Auth;

use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Traits\HttpResponses;
use App\Rules\PhoneNumberLookup;
use App\Notifications\PhoneVerificationOTP;
use App\Services\Twilio\Verify;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    use HttpResponses;

    public function student_login(Request $request){ 
        try{
            if($request->has('phone')){
                $request->merge([
                    'phone' => $request->input('tel_code').$request->input('phone')
                ]);
            }       

            $check = Validator::make($request->all(), 
            [
                'tel_code' => ['required', 'exists:countries,tel_code'],
                'phone' => ['required', new PhoneNumberLookup],
            ]);

            if($check->fails())
            {
                $msg=[];
                $errors = $check->errors();
                foreach ($errors->all() as $message) {
                    $msg[] = $message;
                }
                return $this->error('Bad Request',$msg, 400);
            }


            $country = Country::where('tel_code',$request->input('tel_code'))->first();

            if(!User::role('student')->where('phone', $request->input('phone'))->where('country_id', $country->id)->exists()){
                $user = User::create([
                    'phone' => $request->input('phone'),
                    'country_id' => $country->id,
                ]);
                $user->assignRole('student');
            }

            $value = Cache::get('phone:'.$request->input('phone'));
            if($value == 'lock'){
                return $this->error('Forbidden','Try again in 30 seconds',403);
            }

            $user = User::where('phone', $request->input('phone'))->where('country_id', $country->id)->first();
            $user->notify(new PhoneVerificationOTP());

            return $this->success('Verification OTP sent',$user,200);

        }
        catch(UniqueConstraintViolationException $e){
            return $this->error('Bad Request','Phone number already exists under a different role',400);
        }
        catch(Exception $e){
            return $this->error('Internal Server Error','An error occured',500);
        }
    }

    public function counsellor_login(Request $request){
        try{
            if($request->has('phone')){
                $request->merge([
                    'phone' => $request->input('tel_code').$request->input('phone')
                ]);
            }       

            $check = Validator::make($request->all(), 
            [
                'tel_code' => ['required', 'exists:countries,tel_code'],
                'phone' => ['required', new PhoneNumberLookup],
            ]);
            
            if($check->fails())
            {
                $msg=[];
                $errors = $check->errors();
                foreach ($errors->all() as $message) {
                    $msg[] = $message;
                }
                return $this->error('Bad Request',$msg, 400);
            }


            $country = Country::where('tel_code',$request->input('tel_code'))->first();
            
            if(!User::role('counsellor')->where('phone', $request->input('phone'))->where('country_id', $country->id)->exists()){
                $user = User::create([
                    'phone' => $request->input('phone'),
                    'country_id' => $country->id,
                ]);
                $user->assignRole('counsellor');
            }
            
            $value = Cache::get('phone:'.$request->input('phone'));
            if($value == 'lock'){
                return $this->error('Forbidden','Try again in 30 seconds',403);
            }
            
            $user = User::where('phone', $request->input('phone'))->where('country_id', $country->id)->first();
            $user->notify(new PhoneVerificationOTP());

            return $this->success('Verification OTP sent',$user,200);
        }
        catch(UniqueConstraintViolationException $e){
            return $this->error('Bad Request','Phone number already exists under a different role',400);
        }
        catch(Exception $e){
            return $this->error('Internal Server Error','An error occured',500);
        }
    }

    public function verify_otp(Request $request){
        $check = Validator::make($request->all(), 
        [
            'code' => ['required', 'numeric', 'digits:4'],
            'phone' => ['required', 'exists:users,phone'],
        ]);

        if($check->fails())
        {
            $msg=[];
            $errors = $check->errors();
            foreach ($errors->all() as $message) {
                $msg[] = $message;
            }
            return $this->error('Bad Request',$msg, 400);
        }

        //$user = User::where('phone',$request->input('phone'))->first();

        $check_otp = new Verify();
        $response = $check_otp->verify_otp($request->input('phone'),$request->input('code'));
        if(isset($response->status) && $response->status == 'approved'){
            $user = User::where('phone',$request->input('phone'))->first();
            $user->phone_verified_at = now();
            $user->save();
            $token = $user->createToken($request->header('User-Agent'));
            $data = [
                'profile_status' => $user->status->status,
                'role' => $user->getRoleNames()->first(),
                'phone' => $user->phone,
                'phone_verified_at' => $user->phone_verified_at,
                'access_token' => $token->plainTextToken,
                'token_type' => 'bearer',
                'expires_in' => 0,
            ];
            return $this->success('Phone Verified',$data,200);
        }
        else{
            return $this->error('Bad Request','Incorrect OTP or Phone',400);
        }
    }

    public function resend_otp(Request $request){
        $check = Validator::make($request->all(), 
        [
            'phone' => ['required', 'exists:users,phone'],
        ]);

        if($check->fails())
        {
            $msg=[];
            $errors = $check->errors();
            foreach ($errors->all() as $message) {
                $msg[] = $message;
            }
            return $this->error('Bad Request',$msg, 400);
        }

        $value = Cache::get('phone:'.$request->input('phone'));
        if($value == 'lock'){
            return $this->error('Forbidden','Try again in 30 seconds',403);
        }

        $user = User::where('phone', $request->input('phone'))->first();
        $user->notify(new PhoneVerificationOTP());

        return $this->success('Verification OTP sent',$user,200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return $this->success('User Logged out successfully','Logout successful',200);
    }

    public function delete(Request $request){
        $user_id = $request->user()->id;
        $request->user()->currentAccessToken()->delete();
        $user = User::find($user_id);
        /*$user->documents->delete();*/
        $user->delete();
        return $this->success('User Logged out and Deleted successfully','Delete successful',200);
    }
}
