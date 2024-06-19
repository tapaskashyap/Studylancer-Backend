<?php

namespace App\Http\Controllers\Apis;

use Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

use App\Enums\MaritalStatus;
use App\Enums\VisaType;
use App\Enums\VisaOutcome;
use App\Enums\StudentsHelped;
use App\Models\StudentDetail;
use App\Models\StudentScore;
use App\Models\StudentImmigration;
use App\Models\CounsellorDetail;
use App\Models\User;
use App\Models\Document;
use App\Models\EnglishProficiencyTest;
use App\Models\Multimedia;

class ProfileController extends Controller
{
    use HttpResponses;

    public function user(Request $request){
        $user = $request->user();
        $country = [
            'name' => $user->country->name,
            'code' => $user->country->code,
            'tel_code' => $user->country->tel_code,
            'timezone' => $user->country->timezone,
            'flag' => $user->country->flag
        ];
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'phone_verified_at' => $user->phone_verified_at,
            'country' => $country,
            'avatar' => $user->avatar,
            'role' => $user->getRoleNames()->first(),
            'profile_status' => $user->status->status,
            'approved_at' => $user->approved_at
        ];
        return $this->success('User Info',$data,200);
    }

    public function profile_picture(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'profile_picture' => ['required',File::types(['png', 'jpeg', 'jpg'])->max('5mb')]
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

        $file_path = Storage::putFile('profile_pictures', $request->file('profile_picture'),'public');
        $link = Storage::url($file_path);

        $user->avatar = $link;
        $user->save();

        $data = [
            'avatar' => $link,
        ];

        return $this->success('Profile Picture Updated',$data,200);
    }

    public function get_student_details(Request $request){
        $user = $request->user();
        $country = [
            'name' => $user->country->name,
            'code' => $user->country->code,
            'tel_code' => $user->country->tel_code,
            'timezone' => $user->country->timezone,
            'flag' => $user->country->flag
        ];

        $scores = [];
        foreach($user->details->student_scores as $score){
            $scores[] = [
                'id' => $score->id,
                'english_proficiency_test' => $score->english_proficiency_test->name,
                'listening' => $score->listening,
                'reading' => $score->reading,
                'writing' => $score->writing,
                'speaking' => $score->speaking,
                'total' => $score->total,
                'document' => empty($score->document)?null:[
                    'id' => $score->document->id,
                    'name' => $score->document->name,
                    'document' => $score->document->document,
                    'file_type' => $score->document->file_type
                ]
            ];
        }
        $immigrations = [];
        foreach($user->details->student_immigrations as $immigration){
            $immigrations[] = [
                'id' => $immigration->id,
                'country' => $immigration->country->name,
                'visa_type' => $immigration->visa_type,
                'visa_outcome' => $immigration->visa_outcome,
                'year' => $immigration->year
            ];
        }

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'phone_verified_at' => $user->phone_verified_at,
            'country' => $country,
            'avatar' => $user->avatar,
            'role' => $user->getRoleNames()->first(),
            'profile_status' => $user->status->status,
            'approved_at' => $user->approved_at,
            'country_interested' => $user->details->country->country,
            'state' => $user->details->state,
            'city' => $user->details->city,
            'dob' => $user->details->dob,
            'marital_status' => $user->details->marital_status,
            'notes_for_counsellor' => $user->details->notes_for_counsellor,
            'scores' => $scores,
            'immigrations' => $immigrations
        ];
        return $this->success('Student Details',$data,200);
    }

    public function update_student_details(Request $request){
        $user = $request->user();

        if($request->missing('state') && $request->missing('city') && $request->missing('dob') && $request->missing('marital_status') && $request->missing('notes_for_counsellor')){
            return $this->error('Bad Request','Atleast one parameter is required', 400);
        }

        $check = Validator::make($request->all(), 
        [
            'state' => ['sometimes','required','string'],
            'city' => ['sometimes','required','string'],
            'dob' => ['sometimes','required','date_format:Y-m-d'],
            'marital_status' => ['sometimes','required',new Enum(MaritalStatus::class)],
            'notes_for_counsellor' => ['sometimes','string','required']
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
        $student_details = StudentDetail::find($user->details->id);
        $student_details->fill($request->all());
        $student_details->save();

        $profile_status = $this->update_profile_status($user->id);

        $user = User::find($user->id);
        $country = [
            'name' => $user->country->name,
            'code' => $user->country->code,
            'tel_code' => $user->country->tel_code,
            'timezone' => $user->country->timezone,
            'flag' => $user->country->flag
        ];

        $scores = [];
        foreach($user->details->student_scores as $score){
            $scores[] = [
                'id' => $score->id,
                'english_proficiency_test' => $score->english_proficiency_test->name,
                'listening' => $score->listening,
                'reading' => $score->reading,
                'writing' => $score->writing,
                'speaking' => $score->speaking,
                'total' => $score->total,
                'document' => empty($score->document)?null:[
                    'id' => $score->document->id,
                    'name' => $score->document->name,
                    'document' => $score->document->document,
                    'file_type' => $score->document->file_type
                ]
            ];
        }
        $immigrations = [];
        foreach($user->details->student_immigrations as $immigration){
            $immigrations[] = [
                'id' => $immigration->id,
                'country' => $immigration->country->name,
                'visa_type' => $immigration->visa_type,
                'visa_outcome' => $immigration->visa_outcome,
                'year' => $immigration->year
            ];
        }

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'phone_verified_at' => $user->phone_verified_at,
            'country' => $country,
            'avatar' => $user->avatar,
            'role' => $user->getRoleNames()->first(),
            'profile_status' => $user->status->status,
            'approved_at' => $user->approved_at,
            'country_interested' => $user->details->country->country,
            'state' => $user->details->state,
            'city' => $user->details->city,
            'dob' => $user->details->dob,
            'marital_status' => $user->details->marital_status,
            'notes_for_counsellor' => $user->details->notes_for_counsellor,
            'scores' => $scores,
            'immigrations' => $immigrations
        ];
        return $this->success('Student Details Updated',$data,200);        
    }

    public function get_english_proficiency_tests(){
        $english_proficiency_tests = Cache::rememberForever('english_proficiency_tests', function () {
            return \DB::table('english_proficiency_tests')->select('id','name')->get();
        });

        return $this->success('English Proficiency Tests',$english_proficiency_tests,200);
    }

    public function add_student_scores(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'english_proficiency_test_id' => ['required','numeric','exists:english_proficiency_tests,id'],
            'listening' => ['required','numeric'],
            'reading' => ['required','numeric'],
            'writing' => ['required','numeric'],
            'speaking' => ['required','numeric'],
            'total' => ['required','numeric'],
            'document' => ['required','sometimes', File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])->max('5mb')]
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

        $file = null;
        $file_id = null;
        if($request->has('document')){
            $document_name = EnglishProficiencyTest::find($request->english_proficiency_test_id)->name;
            $file = $this->save_file($request->file('document'),$document_name,'/documents/students',8,$user->id);
            $file_id = $file->id;
        }
                
        $score = StudentScore::create([
            'student_detail_id' => $user->details->id,
            'english_proficiency_test_id' => $request->english_proficiency_test_id,
            'listening' => $request->listening,
            'reading' => $request->reading,
            'writing' => $request->writing,
            'speaking' => $request->speaking,
            'total' => $request->total,
            'document_id' => $file_id,
        ]);

        $profile_status = $this->update_profile_status($user->id);

        $data = [
            'id' => $score->id,
            'english_proficiency_test' => $score->english_proficiency_test->name,
            'listening' => $score->listening,
            'reading' => $score->reading,
            'writing' => $score->writing,
            'speaking' => $score->speaking,
            'total' => $score->total,
            'document' => $file
        ];

        return $this->success('Score Added Successfully',$data,200);
    }

    public function delete_student_scores(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'id' => ['required','numeric','exists:student_scores,id'],
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

        $score_ids = [];
        foreach($user->details->student_scores as $score){
            $score_ids[] = $score->id;
        }
        if(!in_array($request->id, $score_ids)){
            return $this->error('Forbidden Request','Invalid id passed',403);
        }
        $score = StudentScore::find($request->id);
        $doc_id = $score->document_id;
        $res = StudentScore::find($request->id)->delete();
        if(!is_null($doc_id)){
            Storage::delete($score->document->document);
            $dres = Document::find($doc_id)->delete();
        }
        $user = User::find($user->id);
        $scores = [];
        foreach($user->details->student_scores as $score){
            $scores[] = [
                'id' => $score->id,
                'english_proficiency_test' => $score->english_proficiency_test->name,
                'listening' => $score->listening,
                'reading' => $score->reading,
                'writing' => $score->writing,
                'speaking' => $score->speaking,
                'total' => $score->total,
                'document' => empty($score->document)?null:[
                    'id' => $score->document->id,
                    'name' => $score->document->name,
                    'document' => $score->document->document,
                    'file_type' => $score->document->file_type
                ]
            ];
        }

        $profile_status = $this->update_profile_status($user->id);

        $data['scores'] = $scores;

        return $this->success('Score Deleted Successfully',$data,200);
    }

    protected function save_file($file,$name,$path,$document_type_id,$user_id){
        $file_path = Storage::putFile($path, $file);
        $document = Document::create([
            'name' => $name,
            'document' => $file_path,
            'user_id' => $user_id,
            'document_type_id' => $document_type_id,
            'file_type' => $file->getMimeType(),
        ]);

        return $document;
    }

    protected function update_profile_status($user_id){
        $user = User::find($user_id);
        if($user->getRoleNames()->first() == 'student'){
            if( $user->details->student_scores()->exists() && 
                !empty($user->details->notes_for_counsellor) &&
                !empty($user->details->marital_status) &&
                !empty($user->details->dob) &&
                !empty($user->details->city) &&
                !empty($user->details->state) 
            ){
                $user->profile_status_id = 6;
                $user->save();
            }
            else{
                $user->profile_status_id = 4;
                $user->save();   
            }
        }
        if($user->getRoleNames()->first() == 'counsellor'){
            if( !empty($user->details->working_since) &&
                !empty($user->details->students_helped) &&
                !empty($user->details->about_me) 
            ){
                $user->profile_status_id = 6;
                $user->save();
            }
            else{
                $user->profile_status_id = 5;
                $user->save();
            }
        }
        return $user->status->status;
    }

    public function add_student_immigration(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'country_id' => ['required','numeric','exists:countries,id'],
            'visa_type' => ['required','string',new Enum(VisaType::class)],
            'visa_outcome' => ['required','string',new Enum(VisaOutcome::class)],
            'year' => ['required','numeric','min:1900','max:'.date("Y")]
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

        $immigration = StudentImmigration::create([
            'student_detail_id' => $user->details->id,
            'country_id' => $request->country_id,
            'visa_type' => $request->visa_type,
            'visa_outcome' => $request->visa_outcome,
            'year' => $request->year,
        ]);

        $data = [
            'id' => $immigration->id,
            'country' => $immigration->country->name,
            'visa_type' => $immigration->visa_type,
            'visa_outcome' => $immigration->visa_outcome,
            'year' => $immigration->year,
        ];

        return $this->success('Immigration Added Successfully',$data,200);

    }

    public function delete_student_immigration(Request $request){
        $user = $request->user();
        $immigration_ids = [];
        foreach($user->details->student_immigrations as $immigration){
            $immigration_ids[] = $immigration->id;
        }
        if(!in_array($request->id, $immigration_ids)){
            return $this->error('Forbidden Request','Invalid id passed',403);
        }
        $res = StudentImmigration::find($request->id)->delete();
        $user = User::find($user->id);
        $immigrations = [];
        foreach($user->details->student_immigrations as $immigration){
            $immigrations[] = [
                'id' => $immigration->id,
                'country' => $immigration->country->name,
                'visa_type' => $immigration->visa_type,
                'visa_outcome' => $immigration->visa_outcome,
                'year' => $immigration->year
            ];
        }

        $data['immigrations'] = $immigrations;

        return $this->success('Immigration Deleted Successfully',$data,200);
    }

    public function get_student_documents(Request $request){
        $user = $request->user();
        $documents = [];
        foreach($user->documents as $document){
            $documents[] = [
                'id' => $document->id,
                'name' => $document->name,
                'document' => $document->document,
                'file_type' => $document->file_type,
                'document_type' => $document->document_type->type,
            ];
        }
        $data['documents'] = $documents;
        return $this->success('All Documents',$data,200);
    }

    public function delete_student_documents(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'id' => ['required','numeric','exists:documents,id'],
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

        $document_ids = [];
        foreach($user->documents as $document){
            if($document->document_type->id > 3){
                $document_ids[] = $document->id;
            }
        }
        if(!in_array($request->id, $document_ids)){
            return $this->error('Forbidden Request','Invalid id passed',403);
        }
        if(Document::find($request->id)->document_type->id == 8){
            $score = StudentScore::where('document_id',$request->id)->get()->first();
            $score->document_id = null;
            $score->save();
        }
        $res = Document::find($request->id);
        Storage::delete($res->document);
        $res2 = Document::find($request->id)->delete();
        $user = User::find($user->id);
        $documents = [];
        foreach($user->documents as $document){
            $documents[] = [
                'id' => $document->id,
                'name' => $document->name,
                'document' => $document->document,
                'file_type' => $document->file_type,
                'document_type' => $document->document_type->type,
            ];
        }
        $data['documents'] = $documents;
        return $this->success('Documents Renamed Successfully',$data,200);
    }

    public function add_student_documents(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'document' => ['required',File::types(['pdf', 'txt', 'png', 'jpeg', 'jpg', 'odt', 'doc', 'docx'])->max('5mb')]
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

        $file = $this->save_file($request->file('document'),'Other Document','/documents/students',9,$user->id);

        $user = User::find($user->id);
        $documents = [];
        foreach($user->documents as $document){
            $documents[] = [
                'id' => $document->id,
                'name' => $document->name,
                'document' => $document->document,
                'file_type' => $document->file_type,
                'document_type' => $document->document_type->type,
            ];
        }
        $data['documents'] = $documents;
        return $this->success('Document Added Successfully',$data,200);        
    }

    public function rename_student_documents(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'document_id' => ['required','string','exists:documents,id'],
            'name' => ['required','string']
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

        $document_ids = [];
        foreach($user->documents as $document){
            if($document->document_type->id > 3){
                $document_ids[] = $document->id;
            }
        }
        if(!in_array($request->document_id, $document_ids)){
            return $this->error('Forbidden Request','Invalid id passed',403);
        }

        $doc = Document::find($request->document_id);
        $doc->name = $request->name;
        $doc->save();

        $data['documents'] = $doc;
        return $this->success('Documents Renamed Successfully',$data,200);
    }

    public function get_counsellor_details(Request $request){
        $user = $request->user();

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'phone_verified_at' => $user->phone_verified_at,
            'country' => $user->country,
            'avatar' => $user->avatar,
            'role' => $user->getRoleNames()->first(),
            'profile_status' => $user->status->status,
            'approved_at' => $user->approved_at,
            'country_interested' => $user->details->country->country,
            'working_since' => $user->details->working_since,
            'students_helped' => $user->details->students_helped,
            'about_me' => $user->details->about_me,
        ];
        return $this->success('Counsellor Details',$data,200);
    }

    public function update_counsellor_details(Request $request){
        $user = $request->user();

        if($request->missing('working_since') && $request->missing('students_helped') && $request->missing('about_me')){
            return $this->error('Bad Request','Atleast one parameter is required', 400);
        }

        $check = Validator::make($request->all(), 
        [
            'working_since' => ['sometimes','required','numeric','min:1900','max:'.date("Y")],
            'students_helped' => ['sometimes','required','string',new Enum(StudentsHelped::class)],
            'about_me' => ['sometimes','required','string']
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
        $student_details = CounsellorDetail::find($user->details->id);
        $student_details->fill($request->all());
        $student_details->save();

        $profile_status = $this->update_profile_status($user->id);
        
        $user = User::find($user->id);
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'phone_verified_at' => $user->phone_verified_at,
            'country' => $user->country,
            'avatar' => $user->avatar,
            'role' => $user->getRoleNames()->first(),
            'profile_status' => $user->status->status,
            'approved_at' => $user->approved_at,
            'country_interested' => $user->details->country->country,
            'working_since' => $user->details->working_since,
            'students_helped' => $user->details->students_helped,
            'about_me' => $user->details->about_me,
        ];
        return $this->success('Counsellor Details Updated',$data,200);
    }

    public function get_counsellor_documents(Request $request){
        $user = $request->user();

        $documents = [];
        foreach($user->documents as $document){
            $documents[] = [
                'id' => $document->id,
                'name' => $document->name,
                'document' => $document->document,
                'file_type' => $document->file_type,
                'document_type' => $document->document_type->type,
            ];
        }
        $data['documents'] = $documents;
        return $this->success('All Documents',$data,200);
    }

    public function get_counsellor_multimedia(Request $request){
        $user = $request->user();

        $media = [];
        foreach($user->multimedia as $media_file){
            $media[] = [
                'id' => $media_file->id,
                'description' => $media_file->description,
                'media' => $media_file->media,
                'media_url' => $media_file->media_url,
                'file_type' => $media_file->file_type,
                'created_at' => $media_file->created_at
            ];
        }
        $data['multimedia'] = $media;
        return $this->success('All Media Files',$data,200);
    }

    public function create_counsellor_multimedia(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'description' => ['required','string'],
            'media' => [ 'required',
                        File::types(['3gpp', '3gp', 'mp4', 'mpeg', 'ogg', 'mov', 'qt', 'avi', 'wmv', 'flv'])
                        ->max('100mb')
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

        $file = $this->save_media($request->file('media'),$request->description,$user->id,$request->file('media')->getMimeType());

        $data['multimedia'] = $file;
        return $this->success('Media File Uploaded',$data,200);
    }

    protected function save_media($file,$description,$user_id,$mimetype){
        $file_path = Storage::putFile('multimedia', $file, 'public');
        $url = Storage::url($file_path);
        $media = Multimedia::create([
            'user_id' => $user_id,
            'description' => $description,
            'media' => $file_path,
            'media_url' => $url,
            'file_type' => $mimetype,
        ]);
        return $media;
    }

    public function delete_counsellor_multimedia(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'id' => ['required','numeric','exists:multimedia,id'],
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

        $media = Multimedia::find($request->id);
        Storage::delete($media->media);
        $res2 = Multimedia::find($request->id)->delete();

        $user = User::find($user->id);
        $media = [];
        foreach($user->multimedia as $media_file){
            $media[] = [
                'id' => $media_file->id,
                'description' => $media_file->description,
                'media' => $media_file->media,
                'media_url' => $media_file->media_url,
                'file_type' => $media_file->file_type,
                'created_at' => $media_file->created_at
            ];
        }
        $data['multimedia'] = $media;
        return $this->success('Media Files Deleted Successfully',$data,200);
    }

    public function preview_counsellor_profile(Request $request){
        $counsellor = $request->user();

        $media = [];
        foreach($counsellor->multimedia as $media_file){
            $media[] = [
                'id' => $media_file->id,
                'description' => $media_file->description,
                'media' => $media_file->media,
                'media_url' => $media_file->media_url,
                'file_type' => $media_file->file_type,
                'created_at' => $media_file->created_at
            ];
        }

        $data = [
            'id' => $counsellor->id,
            'name' => $counsellor->name,
            'email' => $counsellor->email,
            'phone' => $counsellor->phone,
            'phone_verified_at' => $counsellor->phone_verified_at,
            'country' => $counsellor->country,
            'avatar' => $counsellor->avatar,
            'role' => $counsellor->getRoleNames()->first(),
            'profile_status' => $counsellor->status->status,
            'approved_at' => $counsellor->approved_at,
            'country_interested' => $counsellor->details->country->country,
            'working_since' => $counsellor->details->working_since,
            'students_helped' => $counsellor->details->students_helped,
            'about_me' => $counsellor->details->about_me,
            'review_count' => $counsellor->review_count,
            'review_rating' => $counsellor->review_rating,
            'multimedia' => $media
        ];

        return $this->success('Counsellor Details',$data,200);
    }
}
