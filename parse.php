<?php
$content = file_get_contents('emergency.csv');
$content = str_getcsv($content, "\n\r", ";");
$stam = [];
$content = array_splice($content, 2);
foreach ($content as &$str) {
    $str = explode(';', $str);
    if ($str[3]) {
        $name = explode(',', $str[0]);
        $attr = implode(',', array_splice($name, 1));
        $name = str_replace('"', '', $name[0]);
        $name = preg_replace('/\d*$/','', $name);
        $stam[] = array('type'=>'business', 'name'=>$name, 'attr'=>str_replace('"', '', $attr));
    }
}
file_put_contents('emergency.json', json_encode($stam, JSON_UNESCAPED_UNICODE));
//print $stam[1]['name'];
//print $content[2][0];