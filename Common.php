<?php
namespace App\Http\Library;

use Illuminate\Http\Request;
use File;
/*
|--------------------------------------------------------------------------
| Common class for all n panel basic functions and constants there
|--------------------------------------------------------------------------
*/
class Common 
{
    //
    public static $encrypt = 'encrypt';
    public static $decrypt = 'decrypt';
    public static $base_url = 'http://localhost/Crypto_user/';

    public static function random_string($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	 }

	  public static function custom_hash($action, $string) {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'siva';
	    $secret_iv = 'bharathy';
	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    if ( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if( $action == 'decrypt' ) {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	  }

  	public static function upload_image($request,$param)
  	{
        $imageName = self::random_string(32).'.'.$request->file($param)->getClientOriginalExtension();
        $request->file($param)->move('public/uploads/', $imageName);
        return "public/uploads/" . $imageName;
	 }

  	public static function delete_image($image_path)
  	{
        \File::delete($image_path);
        return true;
	}

}