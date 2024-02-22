<?php

namespace App\HelperTrait;

use Cryptommer\Smsir\Smsir;

trait SendInformationSms
{
    public function SendInformationSms(string $mobilenumber, string $templateName, int $templateId): string
    {
        $mobile = $mobilenumber;
        $smsir = new Smsir(env('smsir_line_number'), env('smsir_api_key'));
        $send = $smsir::Send();
        $name = "$templateName";
        $value = '';
        $parameter = new \Cryptommer\Smsir\Objects\Parameters($name, $value);
        $parameters = array($parameter);
        $send->Verify($mobile, $templateId, $parameters);
        return $value;
    }
}
