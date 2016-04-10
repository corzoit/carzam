<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class UiController extends Controller
{
    public function home(){
    	return view('welcome');
    }

    
}
