<?php
$foo = json_decode(file_get_contents('emergency.json'));
$bar = json_decode(file_get_contents('emergency_bitch.json'));

$all = [];
foreach ($bar as $item) {
    $all[$item->name] = $item;
}
foreach ($foo as $item) {
    if(array_key_exists($item->name, $all)) {
        $item->type = 'all';
    }
    $all[$item->name] = $item;
}
$ready = [];
foreach ($all as &$item) {
    $attr = urlencode($item->attr);
    $geo = file_get_contents("https://geocode-maps.yandex.ru/1.x/?geocode=$attr&format=json");
    $geo = json_decode($geo);
    var_dump($geo->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);
    $item->pos = $geo->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos;
    $ready[] = $item;
}
file_put_contents('emergency_all.json', json_encode($ready, JSON_UNESCAPED_UNICODE));

//$attr = urlencode($all[0]->attr);
//$geo = file_get_contents("https://geocode-maps.yandex.ru/1.x/?geocode=$attr&format=json");
//$geo = json_decode($geo);
//print "https://geocode-maps.yandex.ru/1.x/?geocode=$attr&format=json";
//var_dump($geo->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);
//var_dump($all[0]->name);
//print $geo->response->featureMember[0]['response']['featureMember'][0]['GeoObject']['Point']['pos'];
//print($all);
//print(count($all));
