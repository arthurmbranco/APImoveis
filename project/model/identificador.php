<?php
// URL para onde será enviada a requisição GET

$code = $_POST['identificador'];
$url_identificador = "https://api.dev.redevistorias.com.br/challenge/service/foo/item/".$code;
$url_preco = "https://api.dev.redevistorias.com.br/erp/price_preview";

 
 $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjNiZDY3MDMyNWYyODExZjBjMGVhM2E2MmM3YTMzN2I4NjI2MTMzM2I1OWNlZGY5MTQxZjM2OGE4YzFlYjk1NTc5MWU4YTg3NWFhMzk2MDAwIn0.eyJhdWQiOiJjb21wbGV0dXMiLCJqdGkiOiIzYmQ2NzAzMjVmMjgxMWYwYzBlYTNhNjJjN2EzMzdiODYyNjEzMzNiNTljZWRmOTE0MWYzNjhhOGMxZWI5NTU3OTFlOGE4NzVhYTM5NjAwMCIsImlhdCI6MTU1Mzc3NzQ3OSwibmJmIjoxNTUzNzc3NDc5LCJleHAiOjE1NTM4NjM4NzksInN1YiI6IjY4Ni43NjcuNTAwLTA5Iiwic2NvcGVzIjpbIm9yZGVyOmNyZWF0ZSIsIm9yZGVyOnZpZXciLCJvcmRlcjplZGl0Il19.ejenaPOL53hkn8bZZARf6mv282TRYsr7D_iiiaHSY0L3mRtuZSSs_fcJIsXDnsbvl7H6-ppoaHoERHpdTwKpH8Pd0KxolPrD6SGge7S2R5lqjVX-ukRj1VjiX-pJvAcEVenjR2mbYUwVg2YZPL80S9GXtku8hh2N41GRxYXTJTt0H0EdHvXinrnjxZYlRdnnfgcDkUpD8wWycr4dHLaXeOgiIyNxl4AbezvdkrtQOGKHwnnCSotueR0sAfA4VtpzF7r9AOgB-OTenxnro9-fpnOxkkn-chdw2LJNGqdgUSP6FlGKZBnt5h0zievfy7f2VrijroJxHaQF9agwijQTRg";

// Inicia a sessão cURL
$ch = curl_init();

 //Seta o header e informa o token
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json'
   ));
// Informa a URL onde será enviada a requisição
curl_setopt($ch, CURLOPT_URL, $url_identificador);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
 
// Se true retorna o conteúdo em forma de string para uma variável
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
// Envia a requisição
$result = curl_exec($ch);
$info = curl_getinfo($ch);

if (curl_errno($ch)) { 
   print curl_error($ch); 
   exit();
} 
if($info['http_code'] != 200){
	print "Problema ao acessar a API de consulta do imóvel devido ao seguinte erro HTTP: " . $info['http_code'];
	exit();
}

if(!empty($result)){
	$result = json_decode($result, true);
}

$arr = []; 

$arr['inspection_type'] = $result['inspection_type'];
$arr['building_type'] = $result['edifice_type'];
$arr['area'] = $result['area'];
$arr['furnished'] = $result['furnished'];
$arr['modality'] = $result['inspection_modality'];
$arr['express'] = $result['inspection_express'];


curl_setopt($ch, CURLOPT_URL, $url_preco);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json',
   'Authorization: Bearer ' . $token
   ));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));

$result = curl_exec($ch);
$info = curl_getinfo($ch);

if (curl_errno($ch)) { 
   print curl_error($ch); 
} 

if($info['http_code'] != 200){
	print "Problema ao acessar a API de revisão de preços devido ao seguinte erro HTTP: " . $info['http_code'];
	exit();
}

if(!empty($result)){
	$result = json_decode($result, true);
}

print "O preço estimado da vistoria é de: " . $result['price'];



// Finaliza a sessão
curl_close($ch);

 
 
?>