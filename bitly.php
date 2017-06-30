<?php

$command = $_POST['command'];
$incomingDomain = $_POST['text'];
$token = $_POST['token'];



require_once("auth.php");


#
# replace this token with the token from your slash command configuration page
#

if($token != SLACK_TOKEN){ 
	$msg = "The token for the slash command doesn't match. Check your script.";
	die($msg);
	echo $msg;
}

else {


// API Address: https://api-ssl.bitly.com
// GET /v3/shorten?access_token=ACCESS_TOKEN&longUrl=http%3A%2F%2Fgoogle.com%2F

//$domain = urlencode($incomingDomain);
$domain = checkURL($incomingDomain);


// try to fix domain that does not have http://
if ($domain == FALSE){


			$domain = "http://".$incomingDomain;
			$domain = checkURL($domain);

			
}

if ($domain == FALSE) {

			$reply = "Could not complete request. The domain format is invalid.";
	
			}	


else {


$url_to_check = API_PATH.SHORTEN_METHOD.ACCESS_TOKEN.LONG_URL_REQUEST.$domain.TEXT_FORMAT;

$ch = curl_init($url_to_check);
//curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ch_response = curl_exec($ch);

//$response_array = json_decode($ch_response, TRUE);
	//$shortenedURL = $_GET[API_PATH.SHORTEN_METHOD.ACCESS_TOKEN.LONG_URL_REQUEST.$incomingDomain.TEXT_FORMAT];
$reply = $ch_response;


}




// $response_array = json_decode($ch_response, TRUE);

// if($ch_response === FALSE){

//   # isitup.org could not be reached 
// 	$reply = "Ironically, isitup could not be reached.";

// } else {

// 	if ($response_array['status_code'] == 1){

// 		$reply = ":thumbsup: I am happy to report that *<".$response_array["domain"].">* is *up*!";

// 	}else if ($response_array['status_code'] == 2){

// 		$reply = ":disappointed: I am sorry to report that *<".$response_array["domain"].">* is *down*!";

// 	}else if($response_array['status_code'] == 3){

// 		$reply = ":interrobang: *".$domain."* does not appear to be a valid domain. Please enter both the domain name AND the suffix (example: *amazon.com* or *whitehouse.gov*).";

// 		$reply .= "Please enter both the domain name AND suffix (ex: amazon.com or whitehouse.gov).";

// 	}

// }
echo $reply;

} // close else 





?>

<?php 

// functions 


function checkURL ($domain) {

$var = filter_var($domain, FILTER_VALIDATE_URL);

 if($var == FALSE){

 	// echo "Failed URL Check test\n";
 	 return $var; 

           
        }
 else {

 	 return $domain;
 }

}

?>