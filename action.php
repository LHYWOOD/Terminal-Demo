<html>
	<head>		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/core.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/md5.js"></script>
		<script src="https://cdn.bootcdn.net/ajax/libs/blueimp-md5/2.19.0/js/md5.js"></script>
	</head>
	<body>
		<?php
			$termIp = $_POST['termIp'];
			$TYPE = $_POST['type'];								
			$cmd = $_POST['cmd'];	

			switch ($cmd){
				case "SALE":
					$merchantRef = $_POST['Merchant_Ref'];					 
					$amt = (float) $_POST['amt'];
					$body = '{\"TYPE\":"'.$TYPE.'",\"CMD\":\"SALE\",\"AMT\":"'.$amt.'",\"ECRREF\":"'.$merchantRef.'"}';
					$payload = '{"TYPE":"'.$TYPE.'","CMD":"SALE","AMT":"'.$amt.'","ECRREF":"'.$merchantRef.'"}';	
					break;					
				case "VOID":					 
					$trace = $_POST['trace'];	
					$body = '{\"TYPE\":"'.$TYPE.'",\"CMD\":\"VOID\",\"TRACE\":"'.$trace.'"}';
					$payload = '{"TYPE":"'.$TYPE.'","CMD":"VOID","TRACE":"'.$trace.'"}';	
					break;
				case "REFUND":
					$amt = (float) $_POST['amt'];
					$refnum = $_POST['refnum'];
					$body = '{\"AMT\":"'.$amt.'",\"REFNUM\":"'.$refnum.'",\"CMD\":\"REFUND\",\"TYPE\":"'.$TYPE.'"}';
					$payload = '{"AMT":"'.$amt.'","REFNUM":"'.$refnum.'","CMD":"REFUND","TYPE":"'.$TYPE.'"}';
					break;
				case "RETRIEVAL":
					$trace = $_POST['trace'];
					$body = '{\"TYPE\":"'.$TYPE.'",\"CMD\":\"RETRIEVAL\",\"TRACE\":"'.$trace.'"}';
					$payload = '{"TYPE":"'.$TYPE.'","CMD":"RETRIEVAL","TRACE":"'.$trace.'"}';	
					break;
				case "SETTLE":
					$acqname = $_POST['acqname'];
					$body = '{\"CMD\":\"SETTLE\",\"ACQNAME\":"'.$acqname.'" ,\"TYPE\":"'.$TYPE.'"}';
					$payload = '{"CMD":"SETTLE","ACQNAME":"'.$acqname.'" ,"TYPE":"'.$TYPE.'"}';	
					break;
				case "INSTALMENT":
					$merchantRef = $_POST['Merchant_Ref'];
					$amt = (float) $_POST['amt'];
					$tender = (int) $_POST['tender'];
					$body = '{\"TENDER\":"'.$tender.'",\"AMT\":"'.$amt.'",\"ECRREF\":"'.$merchantRef.'",\"CMD\":\"INSTALMENT\",\"TYPE\":"'.$TYPE.'"}';
					$payload = '{"TENDER":"'.$tender.'","AMT":"'.$amt.'","ECRREF":"'.$merchantRef.'","CMD":"INSTALMENT","TYPE":"'.$TYPE.'"}';
			}	
			$hash = md5($payload);
			echo "<center><p>Waiting...</p></center>";
		?>
		<script script type="text/javascript">
			//function request(){
			const data = '<?=$body?>';
			const hash = '<?=$hash?>';
			var settings = {
			"url": "http://<?=$termIp?>",
			"method": "POST",
			"timeout": 0,
			"headers": {
				"X-MD5": hash,
				"Content-Type": "text/plain"
			},
			"data": data,
			};
							
			$.ajax(settings).done(function (response) {
				var payload = '<?=$payload?>';
				var hash = '<?=$hash?>';
				var payload = jQuery.parseJSON(payload);
				document.write("<h2>Request array: </h2>");
				$.each(payload,function(key, value){
					document.write(key + ': ' + value + '<br>');
				});
				document.write("<p>Hash value: @" + hash + "</p>");

				var json = response;
				var result = jQuery.parseJSON(json);
				var hashr = md5(json);
				document.write("<br><hr><h2>Respond array: </h2>");
				$.each(result,function(key, value){
					document.write(key + ': ' + value + '<br>');			
				});
				document.write('<p>Hash value: @' + hashr + '</p><br>');
			});
			//} 

        </script>		
	</body>
</html>
