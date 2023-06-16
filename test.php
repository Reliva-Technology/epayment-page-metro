<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8000/01-mode.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "AMOUNT":"35.10",
    "MERCHANT_CODE":"mymanjung",
    "ORDER_ID":"MPMM50633231882",
    "CUSTOMER_ID":"13422",
    "CUSTOMER_NAME":"Mohd Ali bin Abu",
    "CUSTOMER_EMAIL":"test@test.com",
    "CUSTOMER_MOBILE":"0137020114",
    "TXN_DESC":"Pembayaran T03000547505"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;