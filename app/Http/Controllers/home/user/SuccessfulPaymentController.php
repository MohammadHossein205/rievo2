<?php

namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuccessfulPaymentController extends Controller
{
    public function index()
    {
        return view('home.user.successful_payment.index');
    }
}
