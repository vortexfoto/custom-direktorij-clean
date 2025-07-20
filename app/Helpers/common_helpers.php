<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist; 
use App\Models\Beauty_listing; 
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;




if (!function_exists('addon_status')) {
    function addon_status($unique_identifier = '')
    {
        try {
            return DB::table('addons')->where('unique_identifier', $unique_identifier)->value('status');
        } catch (\Throwable $e) {
            return null; 
        }
    }
}

if (!function_exists('user')) {
    function user($data){
        return Auth::user()[$data]??'';
    }
}
if (!function_exists('get_image')) {
    function get_image($url)
    {
        $hostname = $_SERVER['HTTP_HOST'] ?? 'localhost';
        if ($hostname == '127.0.0.1:8000') {
            if(file_exists($url) && is_file($url)){
               $url = str_replace('app/public/', '', $url);
               return asset($url);
            }
            return asset('image/placeholder.png');
        }
        if (is_file('public/'.$url) && file_exists('public/'.$url) && $url != '') {
            $url = str_replace('app/public/', '', $url);
            return asset($url);
        }
        return asset('image/placeholder.png');
    } 
}


if (!function_exists('get_all_image')) {
    function get_all_image($url)
    {
        $path = public_path('uploads/' . $url);
        if (is_file($path) && file_exists($path) && $url != '') {
            return asset('uploads/' . $url);
        }
        return asset('image/placeholder.png');
    }
}

if (!function_exists('get_user_image')) {
    function get_user_image($url)
    {
        $path = public_path('uploads/' . $url);
        if (is_file($path) && file_exists($path) && $url != '') {
            return asset('uploads/' . $url);
        }
        return asset('image/user.jpg');
    }
}


if (! function_exists('get_settings')) {
    function get_settings($type = "", $return_type = "") {
        $value = DB::table('system_settings')->where('key', $type)->value('value');
        if($return_type === true){
            return json_decode($value, true);
        }elseif($return_type === 'decode'){
            return json_decode($value, true);
        }elseif($return_type == "object"){
            return json_decode($value);
        }else{
            return $value;
        }
    }
}
if ( ! function_exists('get_all_language'))
{
    function get_all_language(){
        return DB::table('languages')->select('name')->distinct()->get();
    }
}

if ( ! function_exists('get_phrase'))
{
    function get_phrase($phrase = '', $value_replace = array()) {
        $active_language = get_settings('language');
        Session(['active_language' => get_settings('language')]);

        $query = DB::table('languages')->where('name', $active_language)->where('phrase', $phrase);
        if($query->count() > 0){
            $tValue = $query->value('translated');
        }else{
            $tValue = $phrase;
            $all_language = get_all_language();

            if($all_language->count() > 0){
                foreach($all_language as $language){
                    if(DB::table('languages')->where('name', $language->name)->where('phrase', $phrase)->get()->count() == 0){
                        DB::table('languages')->insert(array('name' => strtolower($language->name), 'phrase' => $phrase, 'translated' => $phrase));
                    }
                }
            }else{
                DB::table('languages')->insert(array('name' => 'english', 'phrase' => $phrase, 'translated' => $phrase));
            }
        }

        if(count($value_replace) > 0){
            $translated_value_arr = explode('____', $tValue);
            $tValue = '';
            foreach($translated_value_arr as $key => $value){

                if(array_key_exists($key,$value_replace)){
                    $tValue .= $value.$value_replace[$key];
                }else{
                    $tValue .= $value;
                }
            }
        }

        return $tValue;
    }
}
if (!function_exists('slugify')) {
    function slugify($string)
    {
        $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
        $string = trim($string, '-');
        return strtolower($string);
    }
}
if (!function_exists('get_frontend_settings')) {
    function get_frontend_settings($type = '', $description='')
    {
       $frontend_settings = DB::table('frontend_settings')->where('key', $type)->value('value');
        if($type == 'json') {
            $frontend_settings = json_decode($frontend_settings);
        }
        return $frontend_settings;
    }
}
if (!function_exists('currency')) {
    function currency($price = "")
    {
        $currency_position = DB::table('system_settings')->where('key', 'currency_position')->value('value');
        $code = DB::table('system_settings')->where('key', 'system_currency')->value('value');
        $symbol = DB::table('currencies')->where('id', $code)->value('symbol');

        if($currency_position == 'left'){
            return $symbol.''.$price;
        } else {
            return $price.''.$symbol;
        }
    }
}
// app/helpers.php
if (! function_exists('format_time')) {
    function format_time($time) {
        // Check if the time is a single digit or two-digit integer
        if (is_numeric($time) && (int)$time == $time) {
            $time = $time . ":00";
        }
        return date("g:i A", strtotime($time));
    }
}
if (! function_exists('check_subscription')) {
    function check_subscription($user_id) {
        $subscription = App\Models\Subscription::where('user_id', $user_id)->orderBy('id','DESC')->first();
        if($subscription){
            if(time() > $subscription->expire_date){
                return 0;
            }else{
                return 1;
            }
        }else{
            return 0;
        }
    }
}
if (! function_exists('current_package')) {
    function current_package() {
        $subscription = App\Models\Subscription::where('user_id', auth()->user()->id)->orderBy('id','DESC')->first();
        if($subscription){
             $package_value = App\Models\Pricing::where('id', $subscription->package_id)->value('listing');
            
             $beauty = App\Models\BeautyListing::where('user_id', auth()->user()->id)->count(); 
             $car = App\Models\CarListing::where('user_id', auth()->user()->id)->count(); 
             $restaurant = App\Models\RestaurantListing::where('user_id', auth()->user()->id)->count(); 
             $hotel = App\Models\HotelListing::where('user_id', auth()->user()->id)->count(); 
             $real_estate = App\Models\RealEstateListing::where('user_id', auth()->user()->id)->count();

             $totalListing = $beauty +  $car +  $restaurant + $hotel + $real_estate;
             if($package_value > $totalListing ){
                return 1;
             }
             return 0 ;
        }else{
            return 0;
        }
    }
}

if (! function_exists('nice_file_name')) {
    function nice_file_name($file_title = "", $extension = "")
    {
        return slugify($file_title) . '-' . time() . '.' . $extension;
    }
}


// Get Home page Settings Data
if (! function_exists('get_homepage_settings')) {
    function get_homepage_settings($type = "", $return_type = false)
    {
        $value = DB::table('home_page_settings')->where('key', $type);
        if ($value->count() > 0) {
            if ($return_type === true) {
                return json_decode($value->value('value'), true);
            } elseif ($return_type === "object") {
                return json_decode($value->value('value'));
            } else {
                return $value->value('value');
            }
        } else {
            return false;
        }
    }
}




if (!function_exists('check_wishlist_status')) {
    function check_wishlist_status($listing_id = '', $type = '')
    {
        if (!Auth::check()) {
            return false; 
        }
        $user_id = auth()->user()->id;
        $wishlist = DB::table('wishlists')->where('listing_id', $listing_id)->where('type', $type)->where('user_id', $user_id)->exists();  
        return $wishlist;  
    }
}


if (!function_exists('open_status')) {
    function open_status($listing_id = '', $model = ''){
        $model = 'App\Models'.'\\'.$model;
        $listing = $model::where('id', $listing_id)->first();
        if (!$listing || !$listing->opening_time) {
            return 'Closed';
        }
        $today = strtolower(now()->format('l'));
        $now = now()->format('H:i');
        $openingTimes = json_decode($listing->opening_time, true);

        if (!isset($openingTimes[$today])) {
            return 'Closed';
        }
        $todayOpening = $openingTimes[$today]['open'] ?? 'closed';
        $todayClosing = $openingTimes[$today]['close'] ?? 'closed';
        if ($todayOpening === 'closed' || $todayClosing === 'closed') {
            return 'Closed';
        }
        $todayOpening = convert_time_to_24hr($todayOpening);
        $todayClosing = convert_time_to_24hr($todayClosing);
        if ($todayClosing < $todayOpening) {
            if ($now >= $todayOpening || $now < $todayClosing) {
                return 'Open';
            }
        } else {
            if ($now >= $todayOpening && $now < $todayClosing) {
                return 'Open';
            }
        }
        return 'Closed';
    }
    function convert_time_to_24hr($time) {
        if (strpos($time, ':') === false) {
            $time .= ':00';
        }
        if (!preg_match('/^\d{1,2}:\d{2}$/', $time)) {
            return '00:00';
        }
        return date('H:i', strtotime($time));
    }
}





if (!function_exists('removeScripts')) {
    function removeScripts($text)
    {
        if (!$text) return;
        $trimConetnt = Purifier::clean($text);
        return $trimConetnt;

    }
}
if (!function_exists('sanitize')) {
    function sanitize($text)
    {
        $text = removeScripts($text);
        $text = strip_tags($text);
        return str_replace('&amp;', '&', $text);
    }
}