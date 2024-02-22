<?php

namespace App\HelperTrait;

use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

trait SeoPage
{
    public function SeoPage($seometaTitle, $seometaDescription, $seometaCanonical
        ,                   $opengraphDescription, $opengraphSetTitle, $opengraphSetUrl, $opengraphSetAddProperty, $opengraphSiteName
        ,                   $twittercardSetTitle, $twittercardSetSite, $jsonldSetTitle, $jsonldSetDescription, $jsonldAddImage)
    {
//        SEOMeta::setTitle('گام | آموزشگاه کامپیوتر مکانیک حسابداری');
//        SEOMeta::setDescription('آموزش حضوری تمامی نرم افزار های رشته کامپیوتر , مکانیک , حسابداری از مقدماتی تا پیشرفته با کادری مجرب با هدف بهبود سطح آموزش');
//        SEOMeta::setCanonical('https://gamacademy.ir');
//
//        OpenGraph::setDescription('آموزش حضوری تمامی نرم افزار های رشته کامپیوتر , مکانیک , حسابداری از مقدماتی تا پیشرفته با کادری مجرب با هدف بهبود سطح آموزش');
//        OpenGraph::setTitle('گام | آموزشگاه کامپیوتر مکانیک حسابداری');
//        OpenGraph::setUrl('https://gamacademy.ir');
//        OpenGraph::addProperty('type', 'index');
//        OpenGraph::setSiteName('آموزشگاه گام');
//
//        TwitterCard::setTitle('گام | آموزشگاه کامپیوتر مکانیک حسابداری');
//        TwitterCard::setSite('@gamacademy');
//
//        JsonLd::setTitle('گام | آموزشگاه کامپیوتر مکانیک حسابداری');
//        JsonLd::setDescription('آموزش حضوری تمامی نرم افزار های رشته کامپیوتر , مکانیک , حسابداری از مقدماتی تا پیشرفته با کادری مجرب با هدف بهبود سطح آموزش');
//        JsonLd::addImage(asset('picicon/Logo.svg'));

        //--------------------------------------------//

        SEOMeta::setTitle($seometaTitle);
        SEOMeta::setDescription($seometaDescription);
        SEOMeta::setCanonical($seometaCanonical);

        OpenGraph::setDescription($opengraphDescription);
        OpenGraph::setTitle($opengraphSetTitle);
        OpenGraph::setUrl($opengraphSetUrl);
        OpenGraph::addProperty('type', $opengraphSetAddProperty);
        OpenGraph::setSiteName($opengraphSiteName);

        TwitterCard::setTitle($twittercardSetTitle);
        TwitterCard::setSite($twittercardSetSite);

        JsonLd::setTitle($jsonldSetTitle);
        JsonLd::setDescription($jsonldSetDescription);
        JsonLd::addImage($jsonldAddImage);
    }
}
