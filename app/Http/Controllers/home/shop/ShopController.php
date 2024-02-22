<?php

namespace App\Http\Controllers\home\shop;

use App\HelperTrait\SeoPage;
use App\Http\Controllers\Controller;
use App\Http\Resources\admin\DamIndexResource;
use App\Http\Resources\admin\GroupResource;
use App\Models\Dam;
use App\Models\Damvizhe;
use App\Models\Group;
use App\Models\GroupCompany;
use App\Models\Indexpagesetting;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    use SeoPage;

    public function index()
    {
//        return Dam::where('price', '>=', 100)->where('price', '<=', 10000000)->get();
//        return Dam::whereBetween('price', [100, 10000000])->get();
        $this->SeoPage('ریوو | فروشگاه ریوو'
            , 'فروشگاه ریوو ، خرید و فروش دام'
            , 'https://rievo.ir/shop'
            , 'فروشگاه ریوو ، خرید و فروش دام'
            , 'ریوو | فروشگاه ریوو'
            , 'https://rievo.ir/shop'
            , 'shop'
            , 'دامداری ریوو'
            , 'ریوو | فروشگاه ریوو'
            , '@rievo'
            , 'ریوو | فروشگاه ریوو'
            , 'فروشگاه ریوو ، خرید و فروش دام'
            , asset('img/logo/header_logo.svg'));
        $damscount = Dam::latest()->get();
        $damGroup = GroupResource::collection(Group::latest()->get()->take(6));
        $groupCompany = GroupCompany::latest()->get();
        $Dam = (DamIndexResource::collection(Dam::where('status', 1)->latest()->paginate(16)));
        $damVizhe = DamIndexResource::collection(Damvizhe::where('status', 1)->latest()->get()->take(1));
        return view('home.shop.index', compact('Dam', 'groupCompany', 'damGroup', 'damscount', 'damVizhe'));
    }

    public function GetPagDam(Request $request)
    {
//        if ($request->color == 'all_color' && $request->race == 'all_race')
//            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                ->where('gender', $request->gender)
//                ->where('haveMilk', $request->haveMilk)
//                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                ->paginate(16));
//        else if ($request->color == 'all_color' && $request->race != 'all_race')
//            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                ->where('gender', $request->gender)
//                ->where('haveMilk', $request->haveMilk)
//                ->where('group_company_id', $request->race)
//                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                ->paginate(16));
//        else if ($request->race == 'all_race' && $request->color != 'all_color')
//            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                ->where('gender', $request->gender)
//                ->where('haveMilk', $request->haveMilk)
//                ->where('color', $request->color)
//                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                ->paginate(16));
//        else
//            return DamIndexResource::collection(Dam::where('price', '>=', $request->minValue)->where('price', '<=', $request->maxValue)
//                ->where('weight', '>=', $request->minWeight)->where('weight', '<=', $request->maxWeight)
//                ->where('ageYear', '>=', $request->minDate)->where('ageYear', '<=', $request->maxDate)
//                ->where('gender', $request->gender)
//                ->where('haveMilk', $request->haveMilk)
//                ->where('color', $request->color)
//                ->where('group_company_id', $request->race)
//                ->where('milk_amount', '>=', $request->minMilkAmount)->where('milk_amount', '<=', $request->maxMilkAmount)
//                ->paginate(16));
        if ($request->user_id != '')
            return DamIndexResource::collection(Dam::where('user_id', $request->user_id)->latest()->paginate(16));
        else
            return DamIndexResource::collection(Dam::latest()->paginate(16));
    }

    public function ShopByGroup(Group $group)
    {
        $this->SeoPage($group->name
            , $group->name
            , 'https://rievo.ir/shop/' . $group->name
            , $group->name
            , $group->name
            , 'https://rievo.ir/shop/' . $group->name
            , 'shop'
            , 'دامداری ریوو'
            , $group->name
            , '@rievo'
            , $group->name
            , $group->name
            , asset('img/logo/header_logo.svg'));
        $id = $group->id;
        $Dam = DamIndexResource::collection(Dam::where('status', 1)->where('group_id', $id)->latest()->get());
        $damscount = count($Dam);
        $damGroup = GroupResource::collection(Group::latest()->get()->take(6));
        $groupCompany = GroupCompany::latest()->get();
        return view('home.shop.shopgroup', compact('Dam', 'damscount', 'damGroup', 'groupCompany'));
    }
}
