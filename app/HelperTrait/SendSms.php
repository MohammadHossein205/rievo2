<?php

namespace App\HelperTrait;

use Cryptommer\Smsir\Smsir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait SendSms
{
    public function SendSms(string $mobilenumber, string $templateName, int $templateId): string
    {
        $mobile = $mobilenumber;
        $smsir = new Smsir(env('smsir_line_number'), env('smsir_api_key'));
        $send = $smsir::Send();
        $name = "$templateName";
        $value = Str::upper(Str::random(5));
        $parameter = new \Cryptommer\Smsir\Objects\Parameters($name, $value);
        $parameters = array($parameter);
        $send->Verify($mobile, $templateId, $parameters);
        return $value;
    }
}
