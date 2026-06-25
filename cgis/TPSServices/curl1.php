<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://tpsonline.beacukai.go.id/tps/service.asmx',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'<?xml version="1.0" encoding="utf-8"?>
<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
  <soap12:Body>
    <GetEkspor_NPE xmlns="http://services.beacukai.go.id/">
      <UserName>NCT1</UserName>
      <Password>NCT1123456</Password>
      <No_PE>571942/KPU.01/2022</No_PE>
      <npwp>014944946441000</npwp>
      <kdKantor>040300</kdKantor>
    </GetEkspor_NPE>
  </soap12:Body>
</soap12:Envelope>',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: text/xml'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
echo 'NGOK';
