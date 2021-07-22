<?php

use Illuminate\Support\Facades\Artisan;

function getToken():?string
{
    if(auth()->guest()) {
       return null;
    }

    $token = session()->get('token');
    if ($token) {
        $user = auth('api')->setToken($token)->user();
        if ($user === null) {
            $token = auth('api')->tokenById(\auth()->user()->id);
            session()->put('token', $token);
        }

        return $token;
    }

    $token = auth('api')->tokenById(\auth()->user()->id);
    session()->put('token', $token);

    return $token;
}


function geoDistance(float $lat1, float $lng1, float $lat2, float $lng2, string $unit = "mi") {
    if (($lat1 === $lat2) && ($lng1 === $lng2)) {
        return 0;
    }

    $theta = $lng1 - $lng2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit === "km") {
        return $miles * 1.609344;
    }

    return $miles;
}

if ( ! function_exists('put_permanent_env'))
{
    function put_permanent_env($key, $value, bool $flush = false)
    {
        $path = app()->environmentFilePath();
        $dotenv = \Dotenv\Dotenv::createMutable(base_path());

        try {
            $dotenv->load();
        } catch (Dotenv\Exception\InvalidPathException $e) {
            echo $e;
        }

        $row = $key . '=' . (is_numeric($value) ? $value : "\"".$value."\"");
        $content = file_get_contents($path);

        if(env($key)) {
            $old = env($key);

            $pattern = "/^{$key}(\s+)?=(\s+)?\"?{$old}\"?/m";

            if(preg_match($pattern, $content)) {
                file_put_contents($path, preg_replace(
                    $pattern,
                    $row,
                    $content
                ));

                if ($flush) {
                    Artisan::call('config:cache');
                }

                return true;
            }
        }

        file_put_contents($path, PHP_EOL.$row, FILE_APPEND);

        if ($flush) {
            Artisan::call('config:cache');
        }
    }
}
