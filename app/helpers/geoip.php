<?php
require_once __DIR__ ."/../models/data/ipDataModel.php";

class GeoIP{

	public static function getClientIP() {
		if (getenv('HTTP_CLIENT_IP'))           return getenv('HTTP_CLIENT_IP');
		elseif(getenv('HTTP_X_FORWARDED_FOR'))  return getenv('HTTP_X_FORWARDED_FOR');
		elseif(getenv('HTTP_X_FORWARDED'))      return getenv('HTTP_X_FORWARDED');
		elseif(getenv('HTTP_FORWARDED_FOR'))    return getenv('HTTP_FORWARDED_FOR');
		elseif(getenv('HTTP_FORWARDED'))        return getenv('HTTP_FORWARDED');
		elseif(getenv('REMOTE_ADDR'))           return getenv('REMOTE_ADDR');
		else                                          return 'UNKNOWN';
	}

	public static function getInfo(?string $ip=null, bool $deepDetect=true): ipData|null {

		$output = null;
		if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deepDetect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
		}

		if (filter_var($ip, FILTER_VALIDATE_IP)) {

			$ipdat = null;
			$ipdat = json_decode(file_get_contents(
				"http://www.geoplugin.net/json.gp?ip=$ip", 
				false, 
				stream_context_create([
					'http' => [
                        'timeout' => 5
					]
				])
			));

			if ($ipdat && @strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				$output = new ipData(
                    @$ipdat->geoplugin_city,
                    @$ipdat->geoplugin_regionName,
                    @$ipdat->geoplugin_countryName,
                    @$ipdat->geoplugin_continentName,
                    @$ipdat->geoplugin_timezone
                );
			}
		} 
		
		return $output;
	}
}