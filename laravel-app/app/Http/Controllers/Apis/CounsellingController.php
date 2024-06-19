<?php

namespace App\Http\Controllers\Apis;

use Validator;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Cache;

use App\Models\TimeSlot;
use App\Models\Weekday;
use App\Models\User;
use App\Models\CounsellingBooking;
use App\Models\Transaction;
use App\Models\CounsellorReview;

class CounsellingController extends Controller
{
    use HttpResponses;

    public function get_counselling_settings(Request $request){
        $user = $request->user();

        $time_slots = Cache::rememberForever('time_slots', function () {
            return \DB::table('time_slots')->select('id','slot_name','start','end')->get();
        });

        $weekdays = Cache::rememberForever('weekdays', function () {
            return \DB::table('weekdays')->select('id','name','code')->get();
        });

        $settings = [
            'time_slots' => $user->details->counsellor_timeslots,
            'weekdays' => $user->details->counsellor_weekdays,
            'counselling_fee' => $user->details->counselling_fee,
        ];

        $data = [
            'time_slots' => $time_slots,
            'weekdays' => $weekdays,
            'settings' => $settings
        ];

        return $this->success('Counselling Settings',$data,200);
    }

    public function update_counselling_settings(Request $request){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'time_slots' => ['required','array'],
            'time_slots.*' => ['integer','exists:time_slots,id'],
            'weekdays' => [ 'required','array'],
            'weekdays.*' => ['integer','exists:weekdays,id'],
            'counselling_fee' => ['required', 'string']
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

        $user->details->counsellor_timeslots()->sync($request->time_slots);
        $user->details->counsellor_weekdays()->sync($request->weekdays);

        $user->details->counselling_fee = $request->counselling_fee;
        $user->details->save();

        $time_slots = Cache::rememberForever('time_slots', function () {
            return \DB::table('time_slots')->select('id','slot_name','start','end')->get();
        });

        $weekdays = Cache::rememberForever('weekdays', function () {
            return \DB::table('weekdays')->select('id','name','code')->get();
        });

        $settings = [
            'time_slots' => $user->details->counsellor_timeslots,
            'weekdays' => $user->details->counsellor_weekdays,
            'counselling_fee' => $user->details->counselling_fee,
        ];

        $data = [
            'time_slots' => $time_slots,
            'weekdays' => $weekdays,
            'settings' => $settings
        ];

        return $this->success('Counselling Settings Updated',$data,200);
    }

    public function get_counsellor_settings(Request $request, $id){
        $user = $request->user();

        $counsellor = User::role('counsellor')->where('id',$id)->first();
        if(empty($counsellor)){
            return $this->error('Not Found','No counsellor found', 404);
        }

        $time_slots = Cache::rememberForever('time_slots', function () {
            return \DB::table('time_slots')->select('id','slot_name','start','end')->get();
        });

        $weekdays = Cache::rememberForever('weekdays', function () {
            return \DB::table('weekdays')->select('id','name','code')->get();
        });

        $settings = [
            'time_slots' => $counsellor->details->counsellor_timeslots,
            'weekdays' => $counsellor->details->counsellor_weekdays,
            'counselling_fee' => $counsellor->details->counselling_fee,
        ];

        $data = [
            'time_slots' => $time_slots,
            'weekdays' => $weekdays,
            'settings' => $settings
        ];

        return $this->success('Counsellor Booking Settings',$data,200);
    }

    public function create_bookings(Request $request, $id){
        $user = $request->user();

        $check = Validator::make($request->all(), 
        [
            'time_slot_id' => ['required','integer','exists:time_slots,id'],
            /*'weekday_id' => ['required','integer','exists:weekdays,id'],*/
            'date' => ['required','date','after:today','date_format:Y-m-d'],
            'transaction_number' => ['required', 'string','unique:transactions'],
            'transaction_datetime' => ['required','date_format:Y-m-d H:i:s']
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

        $counsellor = User::role('counsellor')->where('id',$id)->first();
        if(empty($counsellor)){
            return $this->error('Not Found','No counsellor found', 404);
        }

        if(is_null($counsellor->details->counselling_fee)){
            return $this->error('Bad Request','Counsellor has not setup counselling booking', 400);
        }

        $counsellor_timeslot_ids = $counsellor->details->counsellor_timeslots()->pluck('time_slots.id')->toArray();
        $counsellor_weekday_ids = $counsellor->details->counsellor_weekdays()->pluck('weekdays.id')->toArray();

        if(!in_array($request->time_slot_id,$counsellor_timeslot_ids)){
            return $this->error('Bad Request','Counsellor not available at this timeslot', 400);   
        }

        $dayOfWeek = Carbon::parse($request->date)->dayOfWeek;

        if(!in_array(++$dayOfWeek,$counsellor_weekday_ids)){
            return $this->error('Bad Request','Counsellor not available on that date', 400);
        }

        $transaction = new Transaction;
        $transaction->transaction_number = $request->transaction_number;
        $transaction->transaction_datetime = $request->transaction_datetime;
        $transaction->amount = $counsellor->details->counselling_fee;
        $transaction->user_id = $user->id;
        $transaction->save();


        $booking = new CounsellingBooking;
        $booking->counsellor_detail_id = $counsellor->details->id;
        $booking->student_detail_id = $user->details->id;
        $booking->time_slot_id = $request->time_slot_id;
        $booking->weekday_id = ++$dayOfWeek;
        $booking->date = $request->date;
        $booking->transaction_id = $transaction->id;
        $booking->save();

        $bookings = [
            'id' => $booking->id,
            'name' => $counsellor->name,
            'avatar' => $counsellor->avatar,
            'date' => $booking->date,
            'time_slot' => $booking->time_slot,
            'counselling_fee' => $counsellor->details->counselling_fee,
            'transaction_number' => $transaction->transaction_number,
            'transaction_datetime' => $transaction->transaction_datetime,
        ];

        return $this->success('Counselling Booked Successfully',$bookings,200);

    }

    public function get_bookings(Request $request){
        $user = $request->user();

        $today = Carbon::now()->format('Y-m-d');
        
        $limit = $request->limit;
        if($request->missing('limit') || $request->limit <= 0){
            $limit = 5;
        }

        $results = $request->results;
        if($request->missing('results') || ($request->results != 'past' && $request->results != 'upcoming')){
            $results = 'all';
        }

        $bookings = [];

        if($results == 'past'){
            $bookings = $user->details->counselling_bookings()->where('date','<',$today)->orderBy('date','asc')->paginate($limit);
        }
        else if ($results == 'upcoming'){
            $bookings = $user->details->counselling_bookings()->where('date','>=',$today)->orderBy('date','asc')->paginate($limit);   
        }
        else{
            $bookings = $user->details->counselling_bookings()->orderBy('date','asc')->paginate($limit);
        }

        $booking = [];
        if($user->getRoleNames()->first() == 'student'){
            foreach($bookings as $booking_details){
                $booking[] = [
                    'id' => $booking_details->id,
                    'counsellor_id' => $booking_details->counsellor_details->user->id,
                    'counsellor_name' => $booking_details->counsellor_details->user->name,
                    'counsellor_avatar' => $booking_details->counsellor_details->user->avatar,
                    'student_id' => $booking_details->student_details->user->id,
                    'student_name' => $booking_details->student_details->user->name,
                    'student_avatar' => $booking_details->student_details->user->avatar,
                    'date' => $booking_details->date,
                    'time_slot' => $booking_details->time_slot,
                    'weekday' => $booking_details->weekday,
                    'rating_status' => (Carbon::parse($today)->gt($booking_details->date))?true:false,
                    'created_at' => $booking_details->created_at,

                ];
            }
        }
        if($user->getRoleNames()->first() == 'counsellor'){
            foreach($bookings as $booking_details){
                $booking[] = [
                    'id' => $booking_details->id,
                    'counsellor_id' => $booking_details->counsellor_details->user->id,
                    'counsellor_name' => $booking_details->counsellor_details->user->name,
                    'counsellor_avatar' => $booking_details->counsellor_details->user->avatar,
                    'student_id' => $booking_details->student_details->user->id,
                    'student_name' => $booking_details->student_details->user->name,
                    'student_avatar' => $booking_details->student_details->user->avatar,
                    'date' => $booking_details->date,
                    'time_slot' => $booking_details->time_slot,
                    'weekday' => $booking_details->weekday,
                    'created_at' => $booking_details->created_at,

                ];
            }
        }

        return $this->paginationSuccess('Booking List',$booking, $bookings->currentPage(), $bookings->lastPage(), $bookings->perPage(), $bookings->total(), 200);
    }

    public function get_bookings_details(Request $request, $id){
        $user = $request->user();

        $booking = CounsellingBooking::find($id);
        if(empty($booking)){
            return $this->error('Not Found','No counselling bookings found', 404);
        }

        $today = Carbon::now()->format('Y-m-d');

        $details = [];
        if($user->getRoleNames()->first() == 'student'){
            $tran_user = [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar
            ];

            $transaction = [
                'id' => $booking->transaction->id,
                'transaction_number' => $booking->transaction->transaction_number,
                'transaction_datetime' => $booking->transaction->transaction_datetime,
                'amount' => $booking->transaction->amount,
                'user' => $tran_user
            ];

            $details = [
                'id' => $booking->id,
                'counsellor_id' => $booking->counsellor_details->user->id,
                'counsellor_name' => $booking->counsellor_details->user->name,
                'counsellor_avatar' => $booking->counsellor_details->user->avatar,
                'student_id' => $booking->student_details->user->id,
                'student_name' => $booking->student_details->user->name,
                'student_avatar' => $booking->student_details->user->avatar,
                'date' => $booking->date,
                'time_slot' => $booking->time_slot,
                'weekday' => $booking->weekday,
                'rating_status' => (Carbon::parse($today)->gt($booking->date))?true:false,
                'created_at' => $booking->created_at,
                'transaction' => $transaction
            ];
        }
        if($user->getRoleNames()->first() == 'counsellor'){
            $details = [
                'id' => $booking->id,
                'counsellor_id' => $booking->counsellor_details->user->id,
                'counsellor_name' => $booking->counsellor_details->user->name,
                'counsellor_avatar' => $booking->counsellor_details->user->avatar,
                'student_id' => $booking->student_details->user->id,
                'student_name' => $booking->student_details->user->name,
                'student_avatar' => $booking->student_details->user->avatar,
                'date' => $booking->date,
                'time_slot' => $booking->time_slot,
                'weekday' => $booking->weekday,
                'created_at' => $booking->created_at,
            ];
        }

        return $this->success('Counselling Booking Details',$details,200);
    }

    public function post_bookings_review(Request $request, $id){
        $user = $request->user();   

        $check = Validator::make($request->all(), 
        [
            'review' => ['required','string'],
            'rating' => ['required','integer','between:1,5'],
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

        $booking = CounsellingBooking::find($id);
        if(empty($booking)){
            return $this->error('Not Found','No counselling bookings found', 404);
        }

        $today = Carbon::now()->format('Y-m-d');
        if(Carbon::parse($today)->lt($booking->date)){
            return $this->error('Bad Request','Not allowed to post reviews before the scheduled counselling date', 401);
        }

        $review = new CounsellorReview;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->user_id = $user->id;
        $review->counsellor_detail_id = $booking->counsellor_details->id;
        $review->save();

        $rating = 0;
        $review_count = 0;
        foreach($booking->counsellor_details->reviews as $review){
            $review_count = $review_count+1;
            $rating = $rating+$review->rating;
        }

        $counsellor = User::role('counsellor')->where('id',$booking->counsellor_details->user->id)->first();
        $counsellor->review_count = $review_count;
        $counsellor->review_rating = $rating/$review_count;
        $counsellor->save();

        $data = [
            'review_count' => $counsellor->review_count,
            'review_rating' => $counsellor->review_rating,
            'reviews' => $review->review,
            'rating' => $review->rating
        ];

        return $this->success('Counsellor Review Submitted Successfully',$data,200);
    }
}
