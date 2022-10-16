<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TinkoffController extends Controller
{
    public function createPayment(Request $request){
        dd($request->get('sum'));
    }
}
