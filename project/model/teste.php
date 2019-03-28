<?php
// URL para onde será enviada a requisição GET

$code = $_POST['identificador'];
$url_preco = "https://api.dev.redevistorias.com.br/erp/price_preview";

 
 $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjNiZDY3MDMyNWYyODExZjBjMGVhM2E2MmM3YTMzN2I4NjI2MTMzM2I1OWNlZGY5MTQxZjM2OGE4YzFlYjk1NTc5MWU4YTg3NWFhMzk2MDAwIn0.eyJhdWQiOiJjb21wbGV0dXMiLCJqdGkiOiIzYmQ2NzAzMjVmMjgxMWYwYzBlYTNhNjJjN2EzMzdiODYyNjEzMzNiNTljZWRmOTE0MWYzNjhhOGMxZWI5NTU3OTFlOGE4NzVhYTM5NjAwMCIsImlhdCI6MTU1Mzc3NzQ3OSwibmJmIjoxNTUzNzc3NDc5LCJleHAiOjE1NTM4NjM4NzksInN1YiI6IjY4Ni43NjcuNTAwLTA5Iiwic2NvcGVzIjpbIm9yZGVyOmNyZWF0ZSIsIm9yZGVyOnZpZXciLCJvcmRlcjplZGl0Il19.ejenaPOL53hkn8bZZARf6mv282TRYsr7D_iiiaHSY0L3mRtuZSSs_fcJIsXDnsbvl7H6-ppoaHoERHpdTwKpH8Pd0KxolPrD6SGge7S2R5lqjVX-ukRj1VjiX-pJvAcEVenjR2mbYUwVg2YZPL80S9GXtku8hh2N41GRxYXTJTt0H0EdHvXinrnjxZYlRdnnfgcDkUpD8wWycr4dHLaXeOgiIyNxl4AbezvdkrtQOGKHwnnCSotueR0sAfA4VtpzF7r9AOgB-OTenxnro9-fpnOxkkn-chdw2LJNGqdgUSP6FlGKZBnt5h0zievfy7f2VrijroJxHaQF9agwijQTRg";

// Inicia a sessão cURL
$ch = curl_init();


$arr = []; 

$arr['inspection_type'] = "entrada";
$arr['building_type'] = "Casa";
$arr['area'] = 75.0;
$arr['furnished'] = "furnished";
$arr['modality'] = "standard";
$arr['express'] = false;
 //Seta o header e informa o token
 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
   'Content-Type: application/json',
   'Authorization: Bearer ' . $token
   ));
// Informa a URL onde será enviada a requisição
curl_setopt($ch, CURLOPT_URL, $url_preco);
 
// Se true retorna o conteúdo em forma de string para uma variável
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
 
// Envia a requisição
$result = curl_exec($ch);
$info = curl_getinfo($ch);

if (curl_errno($ch)) { 
   print curl_error($ch); 
} 

if($info['http_code'] != 200){
	header('Location: ../index.php?msg=1');
}
var_dump($result);




// Finaliza a sessão
curl_close($ch);

 
 
?>