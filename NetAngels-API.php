<?php
/*
 * This file is part of NetAngels API.
 *
 * (c) Ilya Shipitsin <chipitsine@gmail.com>
 *
 */
namespace chipitsine;

/**
 *
 * @author Ilya Shipitsin <chipitsine@gmail.com>
 */

class NetAngelsAPI
{
    protected $login;
    protected $password;

    protected $guzzle;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;

	$this->guzzle = new \GuzzleHttp\Client([
		'cookies' => true,
		'headers' => [
			'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64; rv:31.0) Gecko/20100101 Firefox/31.0',
		],
	]);

    }

    public function zones()
    {
	$response = $this->guzzle->request('GET', 'https://panel.netangels.ru/api/v1/dnszone/', [
		'auth' => [$this->login, $this->password],
		'debug' => false,
		'headers' => [
			'Accept'     => 'application/json',
		]
	] );

	$body_json = json_decode($response->getBody(), true);
        return $body_json['objects'];
    }

    public function get_zone_by_id($id)
    {
        $response = $this->guzzle->request('GET', 'https://panel.netangels.ru/api/v1/dnszone/'.$id.'/', [
                'auth' => [$this->login, $this->password],
                'debug' => false,
                'headers' => [
                        'Accept'     => 'application/json',
                ]
        ] );

        $body_json = json_decode($response->getBody(), true);
        return $body_json;
    }

    public function get_zone_id_by_name($name)
    {
	foreach($this->zones() as $zone){
		if($zone['name'] == $name){
			return $zone['id'];
		}
	}
	return false;
    }

    public function set_zone_comment_ttl($id, $ttl, $comment)
    {
	$response = $this->guzzle->request('PUT', 'https://panel.netangels.ru/api/v1/dnszone/'.$id.'/', [
		'auth' => [$this->login, $this->password],
		'debug' => false,
		'headers' => [
			'Accept'        => 'application/json',
			'Content-Type'  => 'application/json',
		],
		'json' => [
			'ttl' => $ttl,
			'comment' => $comment,
		],
	] );

    }

    public function get_zonerecords($url)
    {
        $response = $this->guzzle->request('GET', 'https://panel.netangels.ru'.$url, [
                'auth' => [$this->login, $this->password],
                'debug' => false,
                'headers' => [
                        'Accept'     => 'application/json',
                ]
        ] );

        $body_json = json_decode($response->getBody(), true);
        return $body_json;
    }


}
