<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        $composer = file_get_contents(base_path('composer.json'));
        $composer = json_decode($composer,true);

        $version = $composer['version'];

        return view('about', get_defined_vars());
    }
}
