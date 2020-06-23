<?php
/*
 * 
 *
 *     
 *
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mbox_home  =   getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
require     $mbox_home . '/vendor/autoload.php';

/*
 * Email properties
 * 
 *
 */

$props	 = parse_ini_file($mbox_home . '/init/Day21.ini'); 


$mail 	= new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPDebug 	= 	0;
$mail->ContentType	= 	"text/html";  
$mail->CharSet		=	"UTF-8"; 
$mail->Encoding 	=	"base64";

$mail->Host 		=  	$props['Host'];
$mail->Port 		= 	$props['Port'];
$mail->SMTPSecure 	=  	$props['SMTPSecure'];
$mail->SMTPAuth 	=  	$props['SMTPAuth'];
$mail->Username 	=  	$props['Username'];
$mail->Password 	=  	$props['Password'];

$mail->setFrom        	($props['setFrom']);
$mail->isHTML          	($props['isHtml']);

foreach ($props['To']  as $addr) { $mail->addAddress($addr); }
foreach ($props['Cc']  as $addr) { $mail->addCC($addr); }
foreach ($props['Bcc'] as $addr) { $mail->addBCC($addr); }

$Day0		= $props['Day0'];

$Day0 		= strtotime($Day0);
$DayN		= strtotime(date("Y-m-d"));
$N		= ($DayN - $Day0)/60/60/24;

if($N <1 or $N > 21) {
	echo "Not started or finished! \n";
	echo "Day # is " . $N . " \n";
	exit();
}

$DaySubject	= "<h2><string>Day " . $N . " - " . date("l, j F Y") . "</strong></h2>";

$urls = array();
array_push($urls, "Day0");
foreach ($props['urls']  as $url) { 
	array_push($urls, $url);
}

$urls2 = array();
array_push($urls, "Day0");
foreach ($props['urls2']  as $url) { 
	array_push($urls2, $url);
}

/*
 * Email Subject and Body
 * 
 *
 */
$url                    = "<a href='" . $urls2[$N] . "'>" . $urls[$N] . "</a>"  ;
$daycont                = file_get_contents($mbox_home . "/cont1/Day".$N.".htm");
$Subject                = "Day " . $N;
$Body                   = $daycont . "<br><br>" . $url; 

$mail->Subject =  	$Subject;
$mail->Body =        	$Body;
$mail->send();


/* for test all */
for($i=1;$i<=21;$i++) {
	$url                    = "<a href='" . $urls[$i] . "'>" . $urls[$i] . "</a>"  ;
	$daycont                = file_get_contents($mbox_home . "/cont1/Day".$i.".htm");
	$Subject                = "Day " . $i;
	$Body                   = $daycont . "<br><br>" . $url; 

	$mail->Subject =  	$Subject;
	$mail->Body =        	$Body;
	$mail->send();
}


?>
