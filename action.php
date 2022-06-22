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
		
?>
