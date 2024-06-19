<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Cache;

use App\Models\HomeBanner;
use App\Models\User;
use App\Models\CounsellorDetail;
use App\Models\Multimedia;

class HomeController extends Controller
{
    use HttpResponses;

    public function home(Request $request){
        $user = $request->user();

        $banners = Cache::rememberForever('home_banners', function () {
            return \DB::table('home_banners')->select('id','name','link','image')->get();
        });

        $data = [
            'banners' => $banners,
        ];

        return $this->success('Home Screen Banners',$data,200);
    }

    public function list_counsellors(Request $request){
        $user = $request->user();
        $limit = $request->limit;
        if($request->missing('limit') || $request->limit <= 0){
            $limit = 5;
        }
        $country_id = $user->details->available_country_id;
        $counsellors = User::role('counsellor')->with('details')->whereHasMorph('details',CounsellorDetail::class,function ($query) use($country_id)  {
                            $query->where('available_country_id', $country_id);
                        })->whereNotNull('approved_at')->orderBy('review_rating','desc')->paginate($limit);
        $counsellor_data=[];
        foreach($counsellors as $counsellor){
            $counsellor_data[] = [
                'id' => $counsellor->id,
                'name' => $counsellor->name,
                'avatar' => $counsellor->avatar,
                'review_count' => $counsellor->review_count,
                'review_rating' => $counsellor->review_rating
            ];
        }

        return $this->paginationSuccess('List of Counsellor',$counsellor_data, $counsellors->currentPage(), $counsellors->lastPage(), $counsellors->perPage(), $counsellors->total(), 200);
    }

    public function details_counsellors(Request $request, $id){
        //$user = $request->user();

        $counsellor = User::role('counsellor')->where('id',$id)->first();
        if(empty($counsellor)){
            return $this->error('Not Found','No counsellor found', 404);
        }

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
            'multimedia' => $media,
            'counselling_fee' => $counsellor->details->counselling_fee,
            'counselling_status' => is_null($counsellor->details->counselling_fee)?false:true
        ];

        return $this->success('Counsellor Details',$data,200);
    }

    public function reviews_counsellors(Request $request, $id){
        $counsellor = User::role('counsellor')->where('id',$id)->first();
        if(empty($counsellor)){
            return $this->error('Not Found','No counsellor found', 404);
        }

        $one = 0;
        $two = 0;
        $three = 0;
        $four = 0;
        $five = 0;

        $reviews = [];
        foreach($counsellor->details->reviews as $review){
            $reviews[] = [
                'id' => $review->id,
                'review' => $review->review,
                'rating' => $review->rating,
                'created_at' => $review->created_at,
                'user' => [
                    'id' => $review->user->id,
                    'name' => $review->user->name,
                    'avatar' => $review->user->avatar,
                ]
            ];
            $one = ($review->rating == '1.0')?++$one:$one;
            $two = ($review->rating == '2.0')?++$two:$two;
            $three = ($review->rating == '3.0')?++$three:$three;
            $four = ($review->rating == '4.0')?++$four:$four;
            $five = ($review->rating == '5.0')?++$five:$five;
        }
        $data = [
            'review_count' => $counsellor->review_count,
            'review_rating' => $counsellor->review_rating,
            'one_star' => $one,
            'two_star' => $two,
            'three_star' => $three,
            'four_star' => $four,
            'five_star' => $five,
            'reviews' => $reviews
        ];

        return $this->success('Counsellor Reviews',$data,200);
    }

    public function multimedia_counsellors(Request $request, $id){
        $counsellor = User::role('counsellor')->where('id',$id)->first();
        if(empty($counsellor)){
            return $this->error('Not Found','No counsellor found', 404);
        }

        $limit = $request->limit;
        if($request->missing('limit') || $request->limit <= 0){
            $limit = 10;
        }
        
        $multimedia = Multimedia::where('user_id',$counsellor->id)->orderBy('id','desc')->paginate($limit);
        $media = [];
        foreach($multimedia as $media_file){
            $media[] = [
                'id' => $media_file->id,
                'description' => $media_file->description,
                'media' => $media_file->media,
                'media_url' => $media_file->media_url,
                'file_type' => $media_file->file_type,
                'created_at' => $media_file->created_at
            ];
        }
        return $this->paginationSuccess('Counsellors Multimedia',$media, $multimedia->currentPage(), $multimedia->lastPage(), $multimedia->perPage(), $multimedia->total(), 200);
    }
}
