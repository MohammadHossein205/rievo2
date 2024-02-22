<?php

namespace App\Http\Controllers\home\wallet;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\CardActivityResource;
use App\Http\Resources\admin\PaymentRsource;
use App\Models\CardActivity;
use App\Models\Payment;
use App\Models\WalletText;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | کیف پول مجازی'
            , 'نگه داری پول با کیف پول مجازی'
            , 'https://rievo.ir/wallet'
            , 'نگه داری پول با کیف پول مجازی'
            , 'ریوو | کیف پول مجازی'
            , 'https://rievo.ir/wallet'
            , 'wallet'
            , 'ریوو | کیف پول مجازی'
            , 'ریوو | کیف پول مجازی'
            , '@rievo'
            , 'ریوو | کیف پول مجازی'
            , 'نگه داری پول با کیف پول مجازی'
            , asset('img/logo/header_logo.svg'));
        $text = WalletText::first();
        return view('home.wallet.index', compact('text'));
    }

    public function CardActivity(Request $request)
    {
        return PaymentRsource::collection(Payment::where('user_id', auth()->user()->id)->latest()->get());
//        $cardActivity = CardActivityResource::collection(CardActivity::where('user_id', auth()->user()->id)->get());
//        return $cardActivity;
    }
}
