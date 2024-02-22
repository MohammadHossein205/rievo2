<?php

namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FailurePaymentController extends Controller
{
    public function index()
    {
        return view('home.user.failure_payment.index');
    }
}
