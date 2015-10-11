<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/NetAngels-API.php';

$client = new \chipitsine\NetAngelsAPI(  'xxx', 'xxx' );

$id = $client->get_zone_id_by_name('tele-club.ru');
//$client->set_zone_comment_ttl($id, '300', 'comment');

$r = $client->get_zone_by_id($id);

$records = $client->get_zonerecords($r['adnsrecord_set'][0]);

print_r($records);
