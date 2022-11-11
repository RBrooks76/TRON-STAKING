<?php
class Translate extends CI_Model {
	function __construct() { parent::__construct(); }

	function convert_request($sourceLang, $targetLang, $sourceText) {
        $url = 'https://translate.googleapis.com/translate_a/single?client=gtx&sl=' . $sourceLang . '&tl=' . $targetLang . '&dt=t&q=' . urlencode($sourceText);

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		
		$headers = array();
		$headers[] = "Accept: application/json";
		$headers[] = "Authorization: Bearer APIKEY";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		if (curl_errno($ch)) { echo false; }
		curl_close ($ch);

        if(isset($result)) return json_decode($result)[0][0][0];
        else return false;
	}
}