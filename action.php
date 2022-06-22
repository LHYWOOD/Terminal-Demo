<?php
	//session_start();
	require_once 'vendor/autoload.php';	
	use GuzzleHttp\Client;    
	use GuzzleHttp\Psr7;
	use GuzzleHttp\Exception\BadResponseException;
	use GuzzleHttp\Psr7\Request;
	use GuzzleHttp\Promise;
    $clientid = "sunnytest";
    //collect inputs
	$termIp = $_POST['termIp'];
    $merchantRef = $_POST['Merchant_Ref'];
    $amt = (float) $_POST['amt'];
    $type = $_POST['type'];
	$client = new Client();
	$headers = [
	'Content-MD5' => '',
	'Content-Type' => 'text/plain'
	];

	switch ($type){
		case "UNIONPAY":
		case "VM":
			$TYPE = "EDC";
			break;
		case "PAYME":
		case "WECHAT":
		case "ALIPAY":
		case "ALIPAYHK":
		case "FPS":
			$TYPE = "SHOWQR";
			break;
		case "OCTOPUS":
			$TYPE = "OCTOPUS";
			break;
	}
	$body = '{"TYPE":"'.$TYPE.'","CMD":"SALE","AMT":"'.$amt.'","ECRREF":"'.$merchantRef.'"}';
	$request = new Request('POST', $termIp, $headers, $body);
	$res = $client->sendAsync($request)->wait();
	// echo "<p>" . $res->getBody() . "</p>";
	$json1 = json_decode($body);
	echo "<h2>Request array:</h2>";
	foreach($json1 as $key1 => $val1){
		echo $key1 . ": " . $val1;
		echo "<br>";
	}	
	echo "<br><br><hr>";
	$json = json_decode($res->getBody());
	echo "<h2>Respond array:</h2>";
	foreach($json as $key => $val){
		echo $key . ": " . $val;
		echo "<br>";
	}	
	// $command = $_POST['command'];
    // $channel = $_POST['channel'];
    // $duration = $_POST['duration'];
    // $goodsname = $_POST['goodsname'];
	// $success = "https://spiral-developers.space/sunnylam/result.php";
    // $failure = "https://spiral-developers.space/sunnylam/result.php";
    // $webhook = $_POST['Webhook'];
    // $cardtoken = $_POST['cardtoken'];
    // $cardtokensource = $_POST['cardtokensource'];

	// $now = new Datetime("now");
	// $now->setTimeZone(new DateTimeZone('UTC'));
	// $request_datetime = $now->format('Y-m-d\TH:i:s\Z');
	// $payload = $clientid . $merchantRef . $request_datetime;
		
// 	$pkeyid = "-----BEGIN RSA PRIVATE KEY-----
// MIIEowIBAAKCAQEAvxWQw6p+8mwlLqyjyk1svW/0z5gmFuwqNDOc+FEa7r5cPk3I
// V8BOl5Qv75adqCTESVfQNeXvzue8vaBtCLqc5kAQIlVy70R76MrxOGQrvuQQnhZf
// ZWQzzg2IvY6zuaJl2H4E4Iq+qTUdkczKECEZox+C17lsM9xztyhoNSZJWwNU5Fai
// cvv1oqZhk61eZ3Wv7yWShjIzYBS8CEP1P7UIgkMtgmVYrv5RCRQ+BxoQuBvAGNXm
// eTS/sIbgxXelMfcBL6TP7j2njbPTuaJuQnciL41MI1GCEDOoVz5wp1dZfPPdfM2U
// rfW1tdBBdYFjPvzKMBWx+homk8M/yYyBTj9imwIDAQABAoIBAAiT8UG3X6eGT0z/
// FwM34o/GfNjs3Zjd1S8uufczvN/Gz+FEIKA/08deMaCxxDYOIHmiZYhl4BQLtx9U
// GlDv/6cebRr9dwFis6VJpvZ/GK+jEVPncTTeAK1ZUjAgPdUxgxzq21ExKUnzRnaL
// GO8MbVgzS+5fNopFdTRdrf/kzho1wjb2C3WPS/j7nGjup9qK/ZjtSdAxMdT2E1B/
// F2I6vTy/+3fixbW3+oSlk0YvaznV31SAAqRQ7hiELQS4jO+Qaz5YW3r8pdAY2nNb
// yGazois/9RZAyG+dEcei+ugAWnEwx55+j+J3uXLADfanOzKOeFKYiQDki1cC7O5k
// uiACoxECgYEA4lModqh1bwtienX+/S6iGUgbAc0oqjzM+sKJrvusO2uPDZ1Mk5P6
// vWLRx1fhqk+6yjw735F95dcvvFPP0zQ1Nv3iFDkdTTxh8EQAccKLU8IuwsaAShzx
// 2By4qEmxlzU3x9OF4YQW3KpKq29+U8/30NnyYx5PekmbhnBruD3mHAUCgYEA2COE
// oMZIb/FGkOxWbPOpon5qN9aI7KuOCiRHQA9Kzi1lRPmci/sE8spGpbGYsMiyTjy5
// bWGSymiLZGjRRQQUCU0eSfK46JxE9mkVCrpkgh/qFJG77UGdO4thiXSCkOUgbiHe
// NDSFOqKfzXpVvPYYvK5MEPQFea9rFEByA0zYZh8CgYB7Pp2CQCny1lhCJ487f/F1
// ovZR/M5wJbvZsaYYS6R2lxPHbikNFEAucWmbDBgvDkvBZRuVmzzbtFqiS2GYuY1g
// 7M/4A0IZlRAgLmeviykj61JbbozdzvVDoiBMRBUZKjm970mwjKWGdJVE1eoM6esh
// KA3+O7s79GlkxENkiRCNoQKBgDUKilq2LkKicFHSXedA6KlC4qgvUszZ0PK2MnIL
// Dq2IQGjr5LoJcQ5wC2RQMAt6RR+kEVFBd7eKbmLGwkxwksYxkbROB4i2CMp7wTkv
// wsiYMma32OmBh6d8LgSAfiY2xH2ifBhNp0BbdmIDmpTTxABRucMTT2CsZtfCdPhQ
// XG67AoGBAMEDPk93pMumwggbgCLv7TpL3243GBxZqR7vPNuP1CnZp206JhAH2GHv
// SMxO62Hd+0LSvAWQVoeY1fDaDqqfyFkg9gg+kh95cWjImo04sXYjXVHwBP0WjbM6
// xFG1Pzh1KEzW6hsbzuaFt7A+hm5jFUSajHQVp0mCgF8GR1TxEe3B
// -----END RSA PRIVATE KEY-----";		

	// $key = openssl_pkey_get_private($pkeyid);
	// openssl_sign($payload, $signature, $key, OPENSSL_ALGO_SHA256);
	// openssl_free_key($key);

	// try{
	// 	// initiate request
	// 	$url = "https://b8jhphintc.execute-api.ap-east-1.amazonaws.com/v1/merchants/sunnytest/transactions/" . $merchantRef;
	// 	$client = new Client();
	// 	$response = $client->request('PUT', $url, [
	// 		'body' => $data,
	// 		'headers' => [
	// 			'Content-Type' => 'application/json',
	// 			'Spiral-Request-Datetime' => $request_datetime,
	// 			'Spiral-Client-Signature' => base64_encode($signature)
	// 		]
	// 	]);
	// } catch (BadResponseException $e) {
	// 	$response = $e->getResponse();
	// 	$response_body = json_decode($response->getBody());
	// 	$status = $response_body->status;
	// 	$statusCode = $response->getStatusCode();
	// 	$errorMessage = $response_body->error;
	// 	echo "<h1>Status code: " . $statusCode . "</h1><h1>" . $status . ": " . $errorMessage . "</h1>";
	// 	switch ($statusCode) {			
	// 		case "400":
	// 			echo "<p>API message format error</p>";
	// 			break;
	// 		case "401":
	// 			echo "<p>Invalid signature</p>";
	// 			break;
	// 		case "404":
	// 			echo "<p>Access invalid resource</p>";
	// 			break;
	// 		case "501":
	// 			echo "<p>Operation not supported.</p>";
	// 			break;
	// 		case "502":
	// 			echo "<p>Payment host server issues</p>";
	// 			break;
	// 		case "504":
	// 			echo "<p>Network issues with payment host</p>";
	// 			break;			
	// 		}
	// 	// echo "<p>" . $response->getStatusCode() . "</p>";
	// 	exit();
	// }
			
	//verification
// 	$pubkey = "-----BEGIN PUBLIC KEY-----
// MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvxWQw6p+8mwlLqyjyk1s
// vW/0z5gmFuwqNDOc+FEa7r5cPk3IV8BOl5Qv75adqCTESVfQNeXvzue8vaBtCLqc
// 5kAQIlVy70R76MrxOGQrvuQQnhZfZWQzzg2IvY6zuaJl2H4E4Iq+qTUdkczKECEZ
// ox+C17lsM9xztyhoNSZJWwNU5Faicvv1oqZhk61eZ3Wv7yWShjIzYBS8CEP1P7UI
// gkMtgmVYrv5RCRQ+BxoQuBvAGNXmeTS/sIbgxXelMfcBL6TP7j2njbPTuaJuQnci
// L41MI1GCEDOoVz5wp1dZfPPdfM2UrfW1tdBBdYFjPvzKMBWx+homk8M/yYyBTj9i
// mwIDAQAB
// -----END PUBLIC KEY-----";
// 	$pubkeyid = openssl_pkey_get_public($pubkey);
// 	$server_sig_payload = $clientid . $merchantRef . $request_datetime;
// 	$ok = openssl_verify($server_sig_payload, $signature, $pubkeyid, OPENSSL_ALGO_SHA256);
// 	if ($ok == 1) {
// 		echo "ok";

// 	} else {
// 		echo "Invalid key";		
// 	}
// 	openssl_free_key($pubkeyid);	
?>

<script src="https://sandbox-library-checkout.spiralplatform.com/js/v2/spiralpg.min.js"></script>
<script type="text/javascript">
	function init(sessionId) {
		try {
			SpiralPG.init(sessionId);
			setTimeout("pay();", 100);
		} catch (error) {
			document.getElementById("loading").innerHTML = "processing...";
			setTimeout("init(sessionId);", 200);
		}
	}
	function pay() {
		try {
			SpiralPG.pay();
			setTimeout("showButton();", 2000);
		} catch (err) {
			document.getElementById("loading").innerHTML = "processing...";
			setTimeout("pay();", 200);
		}
	}
		
	function showButton() {
		try {
			document.getElementById("loading").innerHTML = "Please click below button to proceed if the page is not been redirected automatically. <br>";
			document.getElementById("loading").innerHTML += "<input type=\"button\" value=\"Click here to proceed.\" onclick=\"pay();\"><br>";
		} catch (err) {
			document.getElementById("loading").innerHTML = err.message;
		}
	}
</script>