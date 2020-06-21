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

$props	 = parse_ini_file($mbox_home . '/Hawazin.ini'); 


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

/* 
echo "Day 0 - " . date('Y-m-d', $Day0) . "\n";
echo "Day N - " . date('Y-m-d', $DayN) . "\n";
echo "Day " . $N . "\n";
 */

$DaySubject	= "<h2><string>Day " . $N . " - " . date("l, j F Y") . "</strong></h2>";

/*
$urls = array(
	'1'=> "https://youtu.be/ifOaXk1Uco8",
	'2'=> "https://youtu.be/ZVBoxhtrXp8",
	'3'=> "https://youtu.be/R9tbgpXiWpM",
	'4'=> "https://youtu.be/gOhO9JbkDjw",
	'5'=> "https://youtu.be/deCyyYn6ef8",
	'6'=> "https://youtu.be/bk5tpc_5xW4",
	'7'=> "https://youtu.be/KYF1JhRG3i8",
	'8'=> "https://youtu.be/0HMa_KKX33o",
	'9'=> "https://youtu.be/HEdreScENJU",
	'10'=> "https://youtu.be/gyt_HyJPRMk",
	'11'=> "https://youtu.be/wqOqFd7XzWM",
	'12'=> "https://youtu.be/1J2RM7-ITQE",
	'13'=> "https://youtu.be/VifbZPkBdP4",
	'14'=> "https://youtu.be/Ya1AB3yObqk",
	'15'=> "https://youtu.be/kQMUDi0_vr0",
	'16'=> "https://youtu.be/CRVMX4A1Sp4",
	'17'=> "https://youtu.be/X2ve6V5qqSU",
	'18'=> "https://youtu.be/Hnr62da-sxc",
	'19'=> "https://youtu.be/Drs8QVTUXmE",
	'20'=> "https://youtu.be/4GsPEiMi6bs",
	'21'=> "https://youtu.be/VDq7sp3yXpI"
);
*/

$urls = array();
array_push($urls, "Day0");

foreach ($props['urls']  as $url) { 
	$mail->addAddress($addr); 
	array_push($urls, $url);
}

/*
 * Email Subject and Body
 * 
 *
 */
$url                    = "<a href='" . $urls[$N] . "'>" . $urls[$N] . "</a>"  ;
$daycont                = file_get_contents($mbox_home . "/cont1/Day".$N.".htm");
$Subject                = "Day " . $N;
$Body                   = $daycont . "<br><br>" . $url; 

$mail->Subject =  	$Subject;
$mail->Body =        	$Body;
$mail->send();


/* for test all */
/*
for($i=1;$i<=21;$i++) {
	$url                    = "<a href='" . $urls[$i] . "'>" . $urls[$i] . "</a>"  ;
	$daycont                = file_get_contents($mbox_home . "/cont1/Day".$i.".htm");
	$Subject                = "Day " . $i;
	$Body                   = $daycont . "<br><br>" . $url; 

	$mail->Subject =  	$Subject;
	$mail->Body =        	$Body;
	$mail->send();
*/

}


?>