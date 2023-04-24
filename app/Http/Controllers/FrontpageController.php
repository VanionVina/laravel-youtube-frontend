<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class FrontpageController extends Controller
{
    public function index() {
        $channels = Channel::get();
        return view('frontpage.index', [
            'channels' => $channels
        ]);
    }
}
