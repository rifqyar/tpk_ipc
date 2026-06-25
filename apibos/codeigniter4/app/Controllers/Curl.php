<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;
use Helper\jwt_helper;
use PhpParser\Node\Expr\Print_;

class Curl extends BaseController
{
	public function index()
	{
			// $curl = curl_init();

			// curl_setopt_array($curl, array(
			// CURLOPT_URL => 'http://localhost:8080/client',
			// CURLOPT_RETURNTRANSFER => true,
			// CURLOPT_ENCODING => '',
			// CURLOPT_MAXREDIRS => 10,
			// CURLOPT_TIMEOUT => 0,
			// CURLOPT_FOLLOWLOCATION => true,
			// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// CURLOPT_CUSTOMREQUEST => 'GET',
			// CURLOPT_HTTPHEADER => array(
			// 	'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYm9zb25saW5lX210aSIsInBhc3MiOiIxMjM0NW10aSJ9.-iKwXdV74oAibQ5YgPRURJViZTkgfvhJ0uUa6IEcn04'
			// ,'Content-Type: application/json'),
			// ));

			// $response = curl_exec($curl);

			// if (!curl_errno($curl)) {
			// 	$info = curl_getinfo($curl);
			// 	echo "Connection Success , This is Url : ", $info['url'], "\r\n";
			// }else{
			// 	echo "Connection Failed =".curl_error($curl);
			// }

			// curl_close($curl);
			// //echo $response;

			// $tes = json_decode($response, true);
			// $count = 0;
			// echo "<table>";
			// echo "<tr><th>No</th> <th>No Dokumen</th> <th>Tanggal Dokumen</th> <th>Type Dok</th></tr>";
			// foreach ($tes['Data'] as $k => $c) {
				
			// 	$count = $count + 1; 
			// 	$NO_DOK = $c['NO_DOK'];
			// 	$TGL_DOK = $c['TGL_DOK'];
			// 	$TYPE_DOK = $c['TYPE_DOK'];
			// 	echo "<tr>";
			// 	echo "<td>$count</td>";
			// 	echo "<td>$NO_DOK</td>";
			// 	echo "<td>$TGL_DOK</td>";
			// 	echo "<td>$TYPE_DOK</td>";
			// 	echo "</tr>";
				

			// };

			// echo "</table>";




			//  $header=array(
			// 		'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYm9zb25saW5lX210aSIsInBhc3MiOiIxMjM0NW10aSJ9.-iKwXdV74oAibQ5YgPRURJViZTkgfvhJ0uUa6IEcn04',
			// 		'Content-Type: application/json',
			// 		'User-Agent: Mozilla/5.0 (Windows NT 5.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0',
			// 		'Accept: text/html,application/xhtml+xml,application/json;q=0.9,*/*;q=0.8',
			// 		'Accept-Language: en-us,en;q=0.5',
			// 		'Accept-Encoding: gzip,deflate',
			// 		'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
			// 		'Keep-Alive: 115',
			// 		'Connection: keep-alive');


			// $ch = curl_init();

			// // set URL and other appropriate options
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			// curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/client");
			// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
			// curl_setopt($ch, CURLOPT_HTTPHEADER,$header); 
			// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			
			
			// // grab URL and pass it to the browser
			// $response =curl_exec($ch);
			
			// if (!curl_errno($ch)) {
			// 	$info = curl_getinfo($ch);
			// 	echo "Connection Success , This is Url : ", $info['url'], "\r\n";
			// }else{
			// 	echo "Connection Failed =".curl_error($ch);
			// }
	
			// curl_close($ch);
			// echo($response);




			// $url ="http://localhost:8080/client";
			// $ch = curl_init();

			// $header=array(
			//   'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYm9zb25saW5lX210aSIsInBhc3MiOiIxMjM0NW10aSJ9.-iKwXdV74oAibQ5YgPRURJViZTkgfvhJ0uUa6IEcn04',
			//   'Content-Type: application/json',
			//   'User-Agent: Mozilla/5.0 (Windows NT 5.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0',
			//   'Accept: text/html,application/xhtml+xml,application/json;q=0.9,*/*;q=0.8',
			//   'Accept-Language: en-us,en;q=0.5',
			//   'Accept-Encoding: gzip,deflate',
			//   'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
			//   'Keep-Alive: 115',
			//   'Connection: keep-alive'
			// );

			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			// curl_setopt($ch, CURLOPT_URL, $url);
			// curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0");
			// curl_setopt($ch, CURLOPT_HEADER,         1);
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			// curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
			// curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			// $data = curl_exec($ch);
		
			// if (!curl_errno($ch)) {
			// 	switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
			// 	  case 200:  # OK
			// 		break;
			// 	  default:
			// 		echo 'Unexpected HTTP code: ', $http_code, "\n";
			// 	}
			//   }
		
			// curl_close($ch);
			// echo $data;




			$header = array(
				'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYm9zb25saW5lX210aSIsInBhc3MiOiIxMjM0NW10aSJ9.-iKwXdV74oAibQ5YgPRURJViZTkgfvhJ0uUa6IEcn04'
				,'Content-Type: application/json',
				'User-Agent: Mozilla/5.0 (Windows NT 5.2; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0',
				'Accept: text/html,application/xhtml+xml,application/json;q=0.9,*/*;q=0.8',
				'Accept-Language: en-us,en;q=0.5',
				'Accept-Encoding: gzip,deflate',
				'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
				'Keep-Alive: 115',
				'Connection: keep-alive'
			);
			
			$ch = curl_init(); // create cURL handle (ch)
			if (!$ch) {
				die("Couldn't initialize a cURL handle");
			}
			// set some cURL options
			$ret = curl_setopt($ch, CURLOPT_URL,            "http://localhost:8080/client");
			$ret = curl_setopt($ch, CURLOPT_HEADER,         1);
			$ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$ret = curl_setopt($ch, CURLOPT_TIMEOUT,        30);
			$ret = curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			
			// execute
			$ret = curl_exec($ch);

				if (!curl_errno($ch)) {
				switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
				  case 200:  # OK
					break;
				  default:
					echo 'Unexpected HTTP code: ', $http_code, "\n";
				}
			  }
		
			curl_close($ch);
			echo $ret;
		

	}


	public function postData(){
		
		$alamat = "";
		$postData =  array('no_dok' => '283658',
		'tgl_dok' => '2020-06-23',
		'type_dok' => 'SPJM');

		$data = http_build_query($postData, '', '&');
		
		$alamat .= $data;
		//echo urldecode($alamat); die();
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => 'http://localhost:8080/data/',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POSTFIELDS =>$alamat,
		CURLOPT_HTTPHEADER => array(
			'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJuYW1lIjoiYm9zb25saW5lX210aSIsInBhc3MiOiIxMjM0NW10aSJ9.-iKwXdV74oAibQ5YgPRURJViZTkgfvhJ0uUa6IEcn04'
		),
		));

		$response = curl_exec($curl);

		if (!curl_errno($curl)) {
			$info = curl_getinfo($curl);
			echo "Connection Success , This is Url : ", $info['url'], "\r\n";
		}else{
			echo "Connection Failed =".curl_error($curl);
		}

		curl_close($curl);
		//echo $response;

		$tes = json_decode($response, true);

		//var_dump($tes['Data']);die();
		$ata = $tes['Data']['NO_DOK'];
		$atas = $tes['Data']['TGL_DOK'];
		$atasa = $tes['Data']['TYPE_DOK'];
		$count = 0;
		$count = $count + 1;
		echo "<table>";
			echo "<tr>  <th>No</th> <th>No Dokumen</th> <th>Tanggal Dokumen</th> <th>Type Dok</th></tr>";
			echo "<tr>";
			echo "<td>$count</td>";
			echo "<td>$ata</td>";
			echo "<td>$atas</td>";
			echo "<td>$atasa</td>";
       		echo "</tr>";
		echo "</table>";
	}
}
