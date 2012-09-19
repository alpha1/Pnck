<?php
if(isset($_SERVER['HTTP_USER_AGENT'])){
$userAgent = $_SERVER['HTTP_USER_AGENT'];
} else {
$userAgent = "not found";
}
if(isset($_SERVER['REMOTE_ADDR'])){
$ip = $_SERVER['REMOTE_ADDR'];
} else {
$ip = "not found";
}
if(isset($_SERVER['HTTP_REFERER'])){
$referer = $_SERVER['HTTP_REFERER'];
} else {
$ip = "";
}
if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
} else {
$lang = "";
}
$hostname = gethostbyaddr($ip);
$os = getOS($userAgent);

function getOS($userAgent) {
	$oses = array (
		'iPhone' => '(iPhone)',
		'Windows 3.11' => 'Win16',
		'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)',
		'Windows 98' => '(Windows 98)|(Win98)',
		'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
		'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
		'Windows 2003' => '(Windows NT 5.2)',
		'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
		'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
		'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'Windows ME' => 'Windows ME',
		'Open BSD'=>'OpenBSD',
		'Sun OS'=>'SunOS',
		'Android'=>'(Android)',
		'iPad'=>'(iPod)',
		'iPhone'=>'(iPhone)',
		'iPod'=>'(iPad)',
		'Safari' => '(Safari)',
		'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
		'Mac OS X 10-6'=>'(Mac OS X 10_6)',
		'Mac OS X 10-7'=>'(Mac OS X 10_7)',
		'QNX'=>'QNX',
		'BeOS'=>'BeOS',
		'OS/2'=>'OS/2',
		'Linux'=>'(Linux)|(X11)',
		'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
	);

	foreach($oses as $os=>$pattern){ // Loop through $oses array
    // Use regular expressions to check operating system type
		//if(eregi($pattern, $userAgent)) { // Check if a value in $oses array matches current user agent.
		if(preg_match("/$pattern/", $userAgent)) { // Check if a value in $oses array matches current user agent.
			return $os; // Operating system was matched so return $oses key
		}
	}
	return 'Unknown'; // Cannot find operating system so return Unknown
}
$pnck = $short;
$sql = mysqli_query($mysqli_connect, "INSERT INTO `stats`(`pnck`, `useragent`, `ipv4`, `browser_lang`, `os`, `hostname`) VALUES ('$short', '$userAgent', '$ip','$lang', '$os', '$hostname')");
if($sql){
//echo "it works";
} else {
//echo mysqli_errno($mysqli_connect);
//print_r(mysqli_error($mysqli_connect));
}
/*
Link to Whois for IP
Link to whois for Hostname
Link to Ping and Traceroute
Link to GeoIP DB
Cookie laws (We store cookies)

split up user agent and look for browsers and versions. 
OS and Version

*/
//sets a cookie to see if you've visited this site, or PNCK domain before
//read OWA cookie for referer medium, source, search_terms
?>