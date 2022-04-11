<?php

namespace App\Services;

use Faker;
use Illuminate\Support\Facades\Http;

class IpGeolocationService {
    
    /**
     * Gets geolocation from given IP
     * @param string $ip ip address
     * @return Array $location location data
     */
    public static function getLocationFromIP($ip) {
        $location = [];
        
        if(!$ip) {
            return $location;
        } 

        try {
            $response = Http::retry(3,100)->get(
                'https://api.ipgeolocation.io/ipgeo',
                [
                    'apiKey' => config('services.ipgeo.key'),
                    'ip' => $ip
                ]
            );

            $data = json_decode($response->body());

            if(json_last_error() !== JSON_ERROR_NONE) {
                return null;
            }

            $location = [
                'country' => $data->country_name,
                'state' => $data->state_prov,
                'city' => $data->city,
                'lat' => $data->latitude,
                'long' => $data->longitude,
                'flag' => $data->country_flag
            ];
        } catch(\Exception $e) {
            // $faker = Faker\Factory::create();
            
            // return [
            //     'lat' => $faker->latitude(),
            //     'long' => $faker->longitude()
            // ];
            
            return null;
        }

        return $location;
    }
}