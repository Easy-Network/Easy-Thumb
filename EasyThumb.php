<?php

class EasyThumb {
	const TYPE_THUMB = 1;
	const TYPE_3D = 2;
	const TYPE_FULL = 3;

	const SIZE_80x60 = '80x60';
	const SIZE_100x75 = '100x75';
	const SIZE_120x90 = '120x90';
	const SIZE_160x120 = '160x120';
	const SIZE_180x135 = '180x135';
	const SIZE_240x180 = '240x180';
	const SIZE_320x240 = '320x240';
	const SIZE_560x420 = '560x420';
	const SIZE_640x480 = '640x480';

	private static $apiKey;
	private static $apiSecret;
	private static $type;
	private static $wait;

	public static function api($apiKey, $apiSecret)
	{
		self::$apiKey = $apiKey;
		self::$apiSecret = $apiSecret;
	}

	public static function type($type)
	{
		self::$type = in_array($type, array(1, 2, 3)) ? $type : 1;
	}

	public static function wait($wait)
	{
		self::$wait = $wait;
	}

	public static function img($url = '', $size = '120x90')
	{
		$u = array('https://www.easy-thumb.net/');

		switch(self::$type)
		{
			case 1 :
			default :
				$u[] = 'thumb';
			break;

			case 2 :
				$u[] = '3d';
			break;

			case 3 :
				$u[] = 'full';
			break;
		}

		$u[] = '?';

		$p = array();

		$p['url'] = $url;
		$p['size'] = $size;

		if(self::$type == self::TYPE_FULL)
			$p['size'] = substr($p['size'], 0, strpos($p['size'], 'x'));

		if(!empty(self::$apiKey) && !empty(self::$apiSecret))
		{
			// Hash url and size
			$p['hash'] = self::getHash($p);

			// Add others params
			$p['key'] = self::$apiKey;
		}

		if(!empty(self::$wait))
			$p['wait'] = self::$wait;

		// Generate query
		foreach($p AS $type => $value)
			$u[] = ($type != 'url' ? '&amp;' : '').$type.'='.($type == 'url' ? urlencode($value) : $value);

		return implode('', $u);
	}

	/**
	 * Create a sha1 hash based on thumb params
	 * 
	 * @param array $p Liste of thumb params
	 * @return string Params hash
	 */
	private static function getHash($p)
	{
		$p['type'] = self::$type;

		// Add secret key for hash
		$p['key'] = self::$apiSecret;

		ksort($p);

		return sha1(implode('-', array_values($p)));
	}
}
