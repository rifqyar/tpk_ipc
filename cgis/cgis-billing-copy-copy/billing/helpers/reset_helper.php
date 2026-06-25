<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('ResetPassword'))
{
   function ResetPassword(){
	//$all = "QWERTYUIOPASDFGHJKLZXCVBNM()`~!@#$%^&*-_=+[]{}\|:;'<>,.?/1234567890mnbvcxzasdfghjklpoiuytrewq";
	$all = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890mnbvcxzasdfghjklpoiuytrewq";
	$mix[] = substr("QWERTYUIOPASDFGHJKLZXCVBNM",rand(0,25),1);
	$mix[] = substr("mnbvcxzasdfghjklpoiuytrewq",rand(0,25),1);
	$mix[] = rand(0,9);
	//$mix[] = substr("()`~!@#$%^&*-_=+[]{}\|:;'<>,.?/",rand(0,30),1); 
	return $pwd .= substr($all,rand(0,90),1).$mix[0].substr($all,rand(0,90),1).$mix[1].substr($all,rand(0,90),1).$mix[2].substr($all,rand(0,90),1).$mix[3]; 
	}
}