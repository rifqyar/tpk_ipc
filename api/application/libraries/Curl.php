<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl
{
	function CallApi($method, $url, $data = false)
    {
        $curl = curl_init();    
        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl, CURLOPT_PUT, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                if ($data)
                    $url = $url.'/'.$data;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);    
        $result = curl_exec($curl);    
        curl_close($curl);    
        return $result;
    } 

}

/* End of file Curl.php */
/* Location: .//C/xampp/htdocs/WEB/LIVE/cgis-billing/billing/libraries/Curl.php */
