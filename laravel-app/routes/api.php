<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware'=>['throttle:60,1']], function(){
    Route::get('/terms-conditions',['as'=>'terms.condition', 'uses'=>'Apis\UtilController@terms_conditions']);
    Route::get('/countries',['as'=>'country.list', 'uses'=>'Apis\UtilController@countries']);
    Route::post('/student/login',['as'=>'student.login','uses'=>'Apis\Auth\LoginController@student_login']);
    Route::post('/counsellor/login',['as'=>'counsellor.login','uses'=>'Apis\Auth\LoginController@counsellor_login']);
    Route::post('/verify-otp',['as'=>'verify.otp','uses'=>'Apis\Auth\LoginController@verify_otp']);
    Route::post('/resend-otp',['as'=>'resend.otp','uses'=>'Apis\Auth\LoginController@resend_otp']);
});

Route::get('/agent', function (Request $request) {
    return $request->header('User-Agent');
});

Route::group(['middleware'=>['auth:sanctum','phone.verified']], function(){
    Route::post('/logout',['as'=>'logout','uses'=>'Apis\Auth\LoginController@logout']);
    Route::post('/delete',['as'=>'delete','uses'=>'Apis\Auth\LoginController@delete']);

    Route::get('/callback',['as'=>'callback','uses'=>'Apis\OnboardingController@callback']);
    Route::post('/callback',['as'=>'request.callback','uses'=>'Apis\OnboardingController@request_callback']);
    Route::post('/counsellor/query',['as'=>'counsellor.query','uses'=>'Apis\OnboardingController@counsellor_query']);

    Route::get('/select/country',['as'=>'get.countries','uses'=>'Apis\OnboardingController@get_countries']);
    Route::post('/select/country',['as'=>'select.countries','uses'=>'Apis\OnboardingController@select_countries']);

    Route::get('/basic/info',['as'=>'get.basic.info','uses'=>'Apis\OnboardingController@get_basic_info']);
    Route::post('/basic/info',['as'=>'basic.info','uses'=>'Apis\OnboardingController@basic_info']);

    Route::get('/basic/documents',['as'=>'get.basic.documents','uses'=>'Apis\OnboardingController@get_basic_documents']);
    Route::post('/basic/documents',['as'=>'basic.documents','uses'=>'Apis\OnboardingController@basic_documents']);
    Route::delete('/basic/documents',['as'=>'delete.basic.documents','uses'=>'Apis\OnboardingController@delete_basic_documents']);

    Route::get('/download/document',['as'=>'download.documents','uses'=>'Apis\OnboardingController@download_documents']);

    Route::get('/home',['as'=>'home','uses'=>'Apis\HomeController@home']);

    Route::get('/user',['as'=>'user','uses'=>'Apis\ProfileController@user']);

    Route::post('/profile/picture',['as'=>'profile.picture','uses'=>'Apis\ProfileController@profile_picture']);

});

Route::group(['middleware'=>['auth:sanctum','phone.verified','students']], function(){
    Route::get('/profile/student/details',['as'=>'student.details','uses'=>'Apis\ProfileController@get_student_details']);
    Route::post('/profile/student/details',['as'=>'update.student.details','uses'=>'Apis\ProfileController@update_student_details']);

    Route::get('/profile/student/scores/tests',['as'=>'get.tests','uses'=>'Apis\ProfileController@get_english_proficiency_tests']);
    Route::post('/profile/student/scores',['as'=>'update.student.scores','uses'=>'Apis\ProfileController@add_student_scores']);
    Route::delete('/profile/student/scores',['as'=>'delete.student.scores','uses'=>'Apis\ProfileController@delete_student_scores']);

    Route::post('/profile/student/immigrations',['as'=>'update.student.immigration','uses'=>'Apis\ProfileController@add_student_immigration']);
    Route::delete('/profile/student/immigrations',['as'=>'delete.student.immigration','uses'=>'Apis\ProfileController@delete_student_immigration']);

    Route::get('/profile/student/documents',['as'=>'student.documents','uses'=>'Apis\ProfileController@get_student_documents']);
    Route::delete('/profile/student/documents',['as'=>'delete.student.documents','uses'=>'Apis\ProfileController@delete_student_documents']);
    Route::post('/profile/student/documents',['as'=>'upload.student.documents','uses'=>'Apis\ProfileController@add_student_documents']);
    Route::post('/profile/student/documents/rename',['as'=>'rename.student.documents','uses'=>'Apis\ProfileController@rename_student_documents']);

    Route::get('/counsellor/list',['as'=>'list.counsellors','uses'=>'Apis\HomeController@list_counsellors']);
    Route::get('/counsellor/details/{id}',['as'=>'details.counsellor','uses'=>'Apis\HomeController@details_counsellors']);
    Route::get('/counsellor/reviews/{id}',['as'=>'reviews.counsellor','uses'=>'Apis\HomeController@reviews_counsellors']);
    Route::get('/counsellor/multimedia/{id}',['as'=>'multimedia.counsellor','uses'=>'Apis\HomeController@multimedia_counsellors']);
});

Route::group(['middleware'=>['auth:sanctum','phone.verified','profile.approved']], function(){
    Route::get('/counselling/bookings/list',['as'=>'get.counselling.bookings','uses'=>'Apis\CounsellingController@get_bookings']);
    Route::get('/counselling/bookings/details/{id}',['as'=>'get.counselling.booking.details','uses'=>'Apis\CounsellingController@get_bookings_details']);
});

Route::group(['middleware'=>['auth:sanctum','phone.verified','profile.approved','students']], function(){
    Route::get('/counselling/bookings/{id}',['as'=>'get.counsellor.settings','uses'=>'Apis\CounsellingController@get_counsellor_settings']);
    Route::post('/counselling/bookings/{id}',['as'=>'post.counselling.bookings','uses'=>'Apis\CounsellingController@create_bookings']);
    Route::post('/counselling/bookings/review/{id}',['as'=>'post.counselling.booking.review','uses'=>'Apis\CounsellingController@post_bookings_review']);
});

Route::group(['middleware'=>['auth:sanctum','phone.verified','profile.complete','profile.approved','students']], function(){
    
});

Route::group(['middleware'=>['auth:sanctum','phone.verified','profile.approved','counsellors']], function(){
    Route::get('/counselling/settings',['as'=>'get.counselling.settings','uses'=>'Apis\CounsellingController@get_counselling_settings']);
    Route::post('/counselling/settings',['as'=>'update.counselling.settings','uses'=>'Apis\CounsellingController@update_counselling_settings']);
});

Route::group(['middleware'=>['auth:sanctum','phone.verified','profile.complete','profile.approved','counsellors']], function(){

});

Route::group(['middleware'=>['auth:sanctum','phone.verified','counsellors']], function(){
    Route::post('/counsellor/selfie',['as'=>'counsellor.selfie','uses'=>'Apis\OnboardingController@counsellor_selfie']);
    Route::get('/profile/counsellor/details',['as'=>'counsellor.details','uses'=>'Apis\ProfileController@get_counsellor_details']);
    Route::post('/profile/counsellor/details',['as'=>'update.counsellor.details','uses'=>'Apis\ProfileController@update_counsellor_details']);

    Route::get('/profile/counsellor/documents',['as'=>'counsellor.documents','uses'=>'Apis\ProfileController@get_counsellor_documents']);

    Route::get('/profile/counsellor/multimedia',['as'=>'get.counsellor.multimedia','uses'=>'Apis\ProfileController@get_counsellor_multimedia']);
    Route::post('/profile/counsellor/multimedia',['as'=>'create.counsellor.multimedia','uses'=>'Apis\ProfileController@create_counsellor_multimedia']);
    Route::delete('/profile/counsellor/multimedia',['as'=>'delete.counsellor.multimedia','uses'=>'Apis\ProfileController@delete_counsellor_multimedia']);

    Route::get('/profile/counsellor/preview',['as'=>'preview.counsellor.profile','uses'=>'Apis\ProfileController@preview_counsellor_profile']);

});

Route::group(['middleware'=>['auth:sanctum','phone.verified','profile.complete','profile.approved']], function(){
    
});