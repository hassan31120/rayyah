<?php
use Illuminate\Support\Facades\App;

function convert2english($string)
{
    $newNumbers = range(0, 9);
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $string = str_replace($arabic, $newNumbers, $string);
    return $string;
}

function fixPhone($string = null)
{
    if (!$string) {
        return null;
    }

    $result = convert2english($string);
    $result = ltrim($result, '00');
    $result = ltrim($result, '0');
    $result = ltrim($result, '+');
    return $result;
}

function Translate($text, $lang)
{

    $api = 'trnsl.1.1.20190807T134850Z.8bb6a23ccc48e664.a19f759906f9bb12508c3f0db1c742f281aa8468';

    $url = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=' . $api
        . '&lang=ar' . '-' . $lang . '&text=' . urlencode($text));
    $json = json_decode($url);
    return $json->text[0];

}

function getYoutubeVideoId($youtubeUrl)
{
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",
        $youtubeUrl, $videoId);
    return $youtubeVideoId = isset($videoId[1]) ? $videoId[1] : "";
}

function lang()
{
    return App()->getLocale();
}

function generateRandomCode()
{
    return '1234';
    return rand(1111, 4444);
}

if (!function_exists('languages')) {
    function languages()
    {
        return ['ar', 'en','fr', 'de', ];
    }
}

if (!function_exists('defaultLang')) {
    function defaultLang()
    {
        return 'en';
    }
}
