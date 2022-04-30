<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{
    public function changeLocale(Request $request) {
        Cookie::queue(
            'locale',
            $request->input('locale'),
            Carbon::now()->addDays(30)->diffInMinutes(Carbon::now())
        );
        
        return "locale changed to " . $request->input('locale');
    }

    public function getLocales() {
        return [
            'locales' => [
                [
                    'value' => "en",
                    'label' => "English",
                    'text' => "🇬🇧"
                ],
                [
                    'value' => "nb",
                    'label' => "Norsk Bokmål",
                    'text' => "🇳🇴"
                ],
            ],
            'selectedLocale' => self::getLocale()
            // 'selectedLocale' => 'nb'
        ];
    }

    public static function getLocale() {
        if(Cookie::get('locale')){
            return Cookie::get('locale');
        } 

        return App::currentLocale();
    }
}
