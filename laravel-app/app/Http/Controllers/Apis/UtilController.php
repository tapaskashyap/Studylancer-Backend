<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\TermsAndCondition;
use Illuminate\Support\Facades\Cache;
use App\Traits\HttpResponses;

class UtilController extends Controller
{
    use HttpResponses;

    public function countries()
    {
        $countries = Cache::rememberForever('countries', function () {
            return \DB::table('countries')->get();
        });
        return $this->success('List of Countries',$countries,200);
    }

    public function terms_conditions()
    {
        $terms_conditions = Cache::rememberForever('terms_conditions', function () {
            return \DB::table('terms_and_conditions')->where('enabled',true)->get()->last();
        });
        return $this->success('Terms and Conditions',$terms_conditions,200);
    }
}
