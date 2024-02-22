<?php

namespace App\Http\Controllers\home\cart;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\DamvizheResource;
use App\Models\Cart;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\GroupCompany;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use SeoPage;

    public function index()
    {
        $this->SeoPage('ریوو | سبد خرید'
            , 'اطلاعات سبد خرید دام های خود را ببینید'
            , 'https://rievo.ir/cart'
            , 'اطلاعات سبد خرید دام های خود را ببینید'
            , 'ریوو | سبد خرید'
            , 'https://rievo.ir/cart'
            , 'cart'
            , 'دامداری ریوو'
            , 'ریوو | سبد خرید'
            , '@rievo'
            , 'ریوو | سبد خرید'
            , 'اطلاعات سبد خرید دام های خود را ببینید'
            , asset('img/logo/header_logo.svg'));
        return view('home.cart.index');
    }

    public function GetCart()
    {
        return Cart::where('user_id', auth()->user()->id)->get();
    }

    public function SetCart(Request $request)
    {
        $checkCart = Cart::where('dam_id', $request->id)->where('dam_type', $request->type)->first();
        $now = Carbon::now();
        if (!$checkCart) {
            $cart = Cart::create([
                'user_id' => auth()->user()->id,
                'dam_id' => $request->id,
                'dam_type' => $request->type,
                'expire_date' => $now->addDay(),
            ]);
            if ($cart) {
                return 200;
            } else {
                return 100;
            }
        } else {
            return 0;
        }
    }

    public function EditCart(Request $request)
    {
        $cart = Cart::all();
        if ($request->type == strval(Dam::class)) {
            $update = $cart->where('user_id', auth()->user()->id)->where('dam_id', $request->dam_id)->where('dam_type', strval(Dam::class))->first();
            $update->update([
                'dam_count' => $request->dam_count
            ]);
        } elseif ($request->type == strval(Damvizhe::class)) {
            $update = $cart->where('user_id', auth()->user()->id)->where('dam_id', $request->dam_id)->where('dam_type', strval(Damvizhe::class))->first();
            $update->update([
                'dam_count' => $request->dam_count
            ]);
        }
    }

    public function DeleteCart(string $id, string $type)
    {
        if ($type == 'normal') {
            $cart = Cart::where('user_id', auth()->user()->id)->where('dam_id', $id)->where('dam_type', strval(Dam::class))->first();
            $cart->delete();
        } else if ($type == 'vizhe') {
            $cart = Cart::where('user_id', auth()->user()->id)->where('dam_id', $id)->where('dam_type', strval(Damvizhe::class))->first();
            $cart->delete();
        }
    }

    public function DeleteAllCart(Request $request)
    {

        if ($request->type == strval(Dam::class)) {
            $cart = Cart::where('user_id', auth()->user()->id)->where('dam_id', $request->id)->where('dam_type', strval(Dam::class))->first();
            $cart->delete();
        } else {
            $cart = Cart::where('user_id', auth()->user()->id)->where('dam_id', $request->id)->where('dam_type', strval(Damvizhe::class))->first();
            $cart->delete();
        }
    }

    public function GetDam(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($type == 'normal')
            $type = strval(Dam::class);
        else if ($type == 'vizhe') {
            $type = strval(Damvizhe::class);
        }
        $dam = [];
        if ($type == strval(Dam::class))
            $dam = DamIndexResource::collection(Dam::where('id', $id)->get());
        else if ($type == strval(Damvizhe::class))
            $dam = DamvizheResource::collection(Damvizhe::where('id', $id)->get());
//        $dam = Dam::where('id', $id)->first();
        return $dam;
    }

    public function GetDamVizhe(Request $request)
    {
        $id = $request->id;
        $dam = DamvizheResource::collection(Damvizhe::where('id', $id)->get());
//        $dam = Dam::where('id', $id)->first();
        return $dam;
    }

    public function GetDamWithCondition(Request $request)
    {
//        if (auth()->user())
        if ($request->color == 'all_color' && $request->race == 'all_race')
            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
                ->where('gender', $request->gender)
                ->where('haveMilk', $request->haveMilk)
//                    ->where('user_id', $request->user_id)
                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
                ->where('status', 1)
                ->get());
        else if ($request->color == 'all_color' && $request->race != 'all_race')
            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
                ->where('gender', $request->gender)
                ->where('haveMilk', $request->haveMilk)
                ->where('group_company_id', $request->race)
//                    ->where('user_id', $request->user_id)
                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
                ->where('status', 1)
                ->get());
        else if ($request->race == 'all_race' && $request->color != 'all_color')
            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
                ->where('gender', $request->gender)
                ->where('haveMilk', $request->haveMilk)
                ->where('color', $request->color)
//                    ->where('user_id', $request->user_id)
                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
                ->where('status', 1)
                ->get());
        else
            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
                ->where('gender', $request->gender)
                ->where('haveMilk', $request->haveMilk)
                ->where('color', $request->color)
                ->where('group_company_id', $request->race)
//                    ->where('user_id', $request->user_id)
                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
                ->where('status', 1)
                ->get());
//        else
//            if ($request->color == 'all_color' && $request->race == 'all_race')
//                return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                    ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                    ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                    ->where('gender', $request->gender)
//                    ->where('haveMilk', $request->haveMilk)
//                    ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                    ->get());
//            else if ($request->color == 'all_color' && $request->race != 'all_race')
//                return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                    ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                    ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                    ->where('gender', $request->gender)
//                    ->where('haveMilk', $request->haveMilk)
//                    ->where('group_company_id', $request->race)
//                    ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                    ->get());
//            else if ($request->race == 'all_race' && $request->color != 'all_color')
//                return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                    ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                    ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                    ->where('gender', $request->gender)
//                    ->where('haveMilk', $request->haveMilk)
//                    ->where('color', $request->color)
//                    ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                    ->get());
//            else
//                return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                    ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                    ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                    ->where('gender', $request->gender)
//                    ->where('haveMilk', $request->haveMilk)
//                    ->where('color', $request->color)
//                    ->where('group_company_id', $request->race)
//                    ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                    ->get());
    }
}
