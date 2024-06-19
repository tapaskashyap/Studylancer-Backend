<?php

namespace App\Http\Controllers\Apis;

use Validator;
use Hash;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use App\Models\CallbackRequest;
use App\Models\TimeSlot;
use App\Models\AvailableCountry;
use App\Models\StudentDetail;
use App\Models\CounsellorDetail;
use App\Models\User;
use App\Models\Document;

use App\Jobs\SendCounsellorQueryMailJob;

class OnboardingController extends Controller
{
    use HttpResponses;

    public function callback(Request $request){
        $time_slot = Cache::rememberForever('time_slots', function () {
            return \DB::table('time_slots')->select('id','slot_name','start','end')->get();
        });

        $user = $request->user();
        $callback_request = CallbackRequest::whereBelongsTo($user)->whereNull('resolved_at')->first();
        $previous_callback = null;
        if(!empty($callback_request)){
            $previous_callback = [
                'slot_name' => $callback_request->time_slot->slot_name,
                'date' => $callback_request->date,
                'timings' => $callback_request->time_slot->start."-".$callback_request->time_slot->end,
                'phone' => $user->phone,
            ];
        }

        $data = [
            'previous_callback_request' => $previous_callback,
            'time_slots' => $time_slot,
        ];

        return $this->success('Available Timeslots',$data,200);
    }

    public function request_callback(Request $request){
        $user = $request->user();
        $callback = CallbackRequest::whereBelongsTo($user)->whereNull('resolved_at')->delete();

        $check = Validator::make($request->all(), 
        [
            'time_slot_id' => ['required','exists:time_slots,id'],
            'date' => ['required','date','after:today'],
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

        $callback_request = new CallbackRequest;
        $callback_request->user_id = $user->id;
        $callback_request->time_slot_id = $request->time_slot_id;
        $callback_request->date = $request->date;
        $callback_request->save();

        $data = [
            'id' => $callback_request->id,
            'slot_name' => $callback_request->time_slot->slot_name,
            'date' => $callback_request->date,
            'timings' => $callback_request->time_slot->start."-".$callback_request->time_slot->end,
            'phone' => $user->phone,
        ];
        
        return $this->success('Callback Request Created',$data,200);
    }

    public function counsellor_query(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'name' => ['required','string'],
            'email' => ['required','email'],
            'text' => ['required','string']
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

        $details['name'] = $request->name;
        $details['email'] = $request->email;
        $details['text'] = $request->text;
        $details['phone'] = $user->phone;
        dispatch(new SendCounsellorQueryMailJob($details));

        return $this->success('Query Successfully Sent','Acknowledgment Mail sent to '.$request->email,200);
    }

    public function get_countries(Request $request){
        $user = $request->user();

        $countries = AvailableCountry::all();
        $country_list = [];
        foreach($countries as $country){
            $country_list[] = [
                'id' => $country->id,
                'name' => $country->country->name,
                'flag' => $country->country->flag,
                'image' => $country->image,
            ]; 
        }

        $user_check = $user->details;
        if(!empty($user_check)){
            $data['profile_status'] = $user->status->status;
            $data['selected_country'] = $user_check->country->country->name;
            $data['countries'] = $country_list;
            return $this->error('Forbidden Request : User already associated with a country',$data, 403);   
        } 

        $data['profile_status'] = $user->status->status;
        $data['role'] = $user->getRoleNames()->first();
        $data['selected_country'] = NULL;
        $data['countries'] = $country_list;
        return $this->success('List of Available Countries',$data,200);
    }

    public function select_countries(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'country_id' => ['required','exists:available_countries,id'],
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
        $user_check = $user->details;
        if(!empty($user_check)){
            $data['profile_status'] = $user->status->status;
            $data['selected_country'] = $user_check->country->country->name;
            return $this->error('Forbidden Request : User already associated with a country',$data, 403);   
        } 

        $details = $this->create_details($request->country_id,$user->getRoleNames()->first()); 
        $user->details()->associate($details);
        $user->profile_status_id = 2;
        $user->save();

        $data['profile_status'] = $user->status->status;
        $data['role'] = $user->getRoleNames()->first();
        $data['selected_country'] = $details->country->country->name;
        return $this->success('Country selection successful ',$data,200);
    }

    protected function create_details($country_id,$role){
        if($role == 'student'){
            return StudentDetail::create([
                'available_country_id' => $country_id,
            ]);    
        }
        elseif($role == 'counsellor'){
            return CounsellorDetail::create([
                'available_country_id' => $country_id,
            ]);
        }
        else{
            return null;
        }
    }

    public function get_basic_info(Request $request){
        $user = $request->user();
        $data['profile_status'] = $user->status->status;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['phone'] = $user->phone;
        $data['role'] = $user->getRoleNames()->first();
        return $this->success('Basic Info',$data,200);
    }

    public function basic_info(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'name' => ['required','string'],
            'email' => ['required','email',Rule::unique('users')->ignore($user->id)],
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

        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = 'https://api.dicebear.com/7.x/initials/svg?seed='.$request->name;
        $user->profile_status_id = 3;
        $user->save();

        $data['profile_status'] = $user->status->status;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['phone'] = $user->phone;
        $data['role'] = $user->getRoleNames()->first();
        return $this->success('Basic Info Updated ',$data,200);
    }

    public function get_basic_documents(Request $request){
        $user = $request->user();
        $documents = [];
        if($user->getRoleNames()->first() == 'student'){
            $marksheet_10 = Document::where(['user_id' => $user->id, 'document_type_id' => 1])->get(['id','name','document','file_type'])->first();
            $marksheet_12 = Document::where(['user_id' => $user->id, 'document_type_id' => 2])->get(['id','name','document','file_type'])->first();
            $passport = Document::where(['user_id' => $user->id, 'document_type_id' => 3])->get(['id','name','document','file_type'])->first();

            $documents = [
                'marksheet_10' => empty($marksheet_10)?null:$marksheet_10,
                'marksheet_12' => empty($marksheet_12)?null:$marksheet_12,
                'passport' => empty($passport)?null:$passport,
            ];
        }
        if($user->getRoleNames()->first() == 'counsellor'){
            $registration_certificate = Document::where(['user_id' => $user->id, 'document_type_id' => 4])->get(['id','name','document','file_type'])->first();
            $government_id = Document::where(['user_id' => $user->id, 'document_type_id' => 5])->get(['id','name','document','file_type'])->first();
            $counsellor_certificate = Document::where(['user_id' => $user->id, 'document_type_id' => 6])->get(['id','name','document','file_type'])->first();

            $documents = [
                'registration_certificate' => empty($registration_certificate)?null:$registration_certificate,
                'government_id' => empty($government_id)?null:$government_id,
                'counsellor_certificate' => empty($counsellor_certificate)?null:$counsellor_certificate,
            ];
        }
        
        $data = [
            'profile_status' => $user->status->status,
            'role' => $user->getRoleNames()->first(),
            'documents' => $documents
        ];
        return $this->success('Basic Documents',$data,200);
    }

    public function basic_documents(Request $request){
        $user = $request->user();
        $documents = [];
        $flag = false;
        if($user->getRoleNames()->first() == 'student'){
            if ($request->missing('marksheet_10') && $request->missing('marksheet_12') && $request->missing('passport')) {
                return $this->error('Bad Request','Atleast one parameter is required', 400);
            }

            $check = Validator::make($request->all(), 
            [
                'marksheet_10' => [
                    'required', 'sometimes',
                    File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])
                        ->max('5mb'),
                ],
                'marksheet_12' => [
                    'required', 'sometimes',
                    File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])
                        ->max('5mb'),
                ],
                'passport' => [
                    'required', 'sometimes',
                    File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])
                        ->max('5mb'),
                ]
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

            if($request->has('marksheet_10')){
                $file = $this->save_file($request->file('marksheet_10'),'10th Marksheet','/documents/students',1,$user->id);
                $documents['marksheet_10'] = $file;
            }
            if($request->has('marksheet_12')){
                $file = $this->save_file($request->file('marksheet_12'),'12th Marksheet','/documents/students',2,$user->id);
                $documents['marksheet_12'] = $file;
            }
            if($request->has('passport')){
                $file = $this->save_file($request->file('passport'),'Passport','/documents/students',3,$user->id);
                $documents['passport'] = $file;
            }
            $marksheet_10 = Document::where(['user_id' => $user->id, 'document_type_id' => 1])->get(['id','name','document','file_type'])->first();
            $marksheet_12 = Document::where(['user_id' => $user->id, 'document_type_id' => 2])->get(['id','name','document','file_type'])->first();
            $passport = Document::where(['user_id' => $user->id, 'document_type_id' => 3])->get(['id','name','document','file_type'])->first();
            if(!empty($marksheet_10) && !empty($marksheet_12) && !empty($passport)){
                $flag = true;
            }
        }
        if($user->getRoleNames()->first() == 'counsellor'){
            if ($request->missing('registration_certificate') && $request->missing('government_id') && $request->missing('counsellor_certificate')) {
                return $this->error('Bad Request','Atleast one parameter is required', 400);
            }

            $check = Validator::make($request->all(), 
            [
                'registration_certificate' => [
                    'required', 'sometimes',
                    File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])
                        ->max('5mb'),
                ],
                'government_id' => [
                    'required', 'sometimes',
                    File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])
                        ->max('5mb'),
                ],
                'counsellor_certificate' => [
                    'required', 'sometimes',
                    File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])
                        ->max('5mb'),
                ]
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

            if($request->has('registration_certificate')){
                $file = $this->save_file($request->file('registration_certificate'),'Registration Certificate','/documents/counsellors',4,$user->id);
                $documents['registration_certificate'] = $file;
            }
            if($request->has('government_id')){
                $file = $this->save_file($request->file('government_id'),'Government ID','/documents/counsellors',5,$user->id);
                $documents['government_id'] = $file;
            }
            if($request->has('counsellor_certificate')){
                $file = $this->save_file($request->file('counsellor_certificate'),'Counsellor Certificate','/documents/counsellors',6,$user->id);
                $documents['counsellor_certificate'] = $file;
            }
            $registration_certificate = Document::where(['user_id' => $user->id, 'document_type_id' => 4])->get(['id','name','document','file_type'])->first();
            $government_id = Document::where(['user_id' => $user->id, 'document_type_id' => 5])->get(['id','name','document','file_type'])->first();
            $counsellor_certificate = Document::where(['user_id' => $user->id, 'document_type_id' => 6])->get(['id','name','document','file_type'])->first();
            if(!empty($registration_certificate) && !empty($government_id) && !empty($counsellor_certificate)){
                $flag = true;
            }
        }

        if($flag){
            $user->profile_status_id = 4;
            $user->save();
        }

        $data = [
            'profile_status' => $user->status->status,
            'role' => $user->getRoleNames()->first(),
            'documents' => $documents
        ];
        return $this->success('Basic Documents',$data,200);
    }

    protected function save_file($file,$name,$path,$document_type_id,$user_id){
        $check_file = Document::where(['user_id' => $user_id, 'document_type_id' => $document_type_id])->get(['name','document','file_type'])->first();
        if(!empty($check_file)){
            Storage::delete($check_file->document);
            $res = Document::where(['user_id' => $user_id, 'document_type_id' => $document_type_id])->delete();
        }
        $file_path = Storage::putFile($path, $file);
        $document = Document::create([
            'name' => $name,
            'document' => $file_path,
            'user_id' => $user_id,
            'document_type_id' => $document_type_id,
            'file_type' => $file->getMimeType(),
        ]);

        return Document::where(['user_id' => $user_id, 'document_type_id' => $document_type_id])->get(['id','name','document','file_type'])->first();
    }

    public function delete_basic_documents(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'document' => ['required','string'],
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

        $document = $request->document;

        $check_file = Document::where(['user_id' => $user->id, 'document' => $document])->get(['name','document','file_type'])->first();
        if(empty($check_file)){
            return $this->error('Not Found','Failed to delete document',404);
        }
        Storage::delete($check_file->document);
        $res = Document::where(['user_id' => $user->id, 'document' => $document])->delete();

        $documents = [];
        if($user->getRoleNames()->first() == 'student'){
            $marksheet_10 = Document::where(['user_id' => $user->id, 'document_type_id' => 1])->get(['id','name','document','file_type'])->first();
            $marksheet_12 = Document::where(['user_id' => $user->id, 'document_type_id' => 2])->get(['id','name','document','file_type'])->first();
            $passport = Document::where(['user_id' => $user->id, 'document_type_id' => 3])->get(['id','name','document','file_type'])->first();

            $documents = [
                'marksheet_10' => empty($marksheet_10)?null:$marksheet_10,
                'marksheet_12' => empty($marksheet_12)?null:$marksheet_12,
                'passport' => empty($passport)?null:$passport,
            ];
        }
        if($user->getRoleNames()->first() == 'counsellor'){
            $registration_certificate = Document::where(['user_id' => $user->id, 'document_type_id' => 4])->get(['id','name','document','file_type'])->first();
            $government_id = Document::where(['user_id' => $user->id, 'document_type_id' => 5])->get(['id','name','document','file_type'])->first();
            $counsellor_certificate = Document::where(['user_id' => $user->id, 'document_type_id' => 6])->get(['id','name','document','file_type'])->first();

            $documents = [
                'registration_certificate' => empty($registration_certificate)?null:$registration_certificate,
                'government_id' => empty($government_id)?null:$government_id,
                'counsellor_certificate' => empty($counsellor_certificate)?null:$counsellor_certificate,
            ];
        }
        $user->profile_status_id = 3;
        $user->save();

        $data = [
            'profile_status' => $user->status->status,
            'role' => $user->getRoleNames()->first(),
            'documents' => $documents
        ];
        return $this->success('Basic Documents',$data,200);
    }

    public function counsellor_selfie(Request $request){
        $user = $request->user();
        $check = Validator::make($request->all(), 
        [
            'selfie' => [
                'required',
                File::types(['png', 'jpeg', 'jpg', 'gif'])
                        ->max('5mb'),
            ],
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

        $document = [];
        $check_doc['selfie'] = Document::where(['user_id' => $user->id, 'document_type_id' => 7])->get(['id','name','document','file_type'])->first();
        if(!empty($check_doc['selfie'])){
            $data = [
                'profile_status' => $user->status->status,
                'role' => $user->getRoleNames()->first(),
                'documents' => $check_doc
            ];
            return $this->error('Forbidden Request : User already uploaded verification selfie',$data, 403);
        }
        $file = $this->save_file($request->file('selfie'),'Counsellor Verification Selfie','/documents/counsellors',7,$user->id);
        $documents['selfie'] = $file;
            
        $user->profile_status_id = 5;
        $user->save();
            
        $data = [
            'profile_status' => $user->status->status,
            'role' => $user->getRoleNames()->first(),
            'documents' => $documents
        ];
        return $this->success('Counsellor Verification Selfie',$data,200);
    }

    public function download_documents(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'document' => ['required','string'],
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

        $document = $request->document;
        $check_doc = Document::where(['user_id' => $user->id, 'document' => $document])->get(['document'])->first();
        if(!empty($check_doc) && ($check_doc->document == $document)){
            return Storage::download($document);
        }
        return $this->error('Not Found','Failed to download document',404);
    }
}
