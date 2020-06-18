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
$TO			="At54Street@Gmail.com";
$CC			="At54Street@Gmail.com";
$BCC 			="At54Street@Gmail.com";


$props		=   array(
	'Host'       =>   "smtp.gmail.com",
	'Port'       =>   587,
	'SMTPSecure' =>   "tls",
	'SMTPAuth'   =>   true,
	'Username'   =>   "At54street@gmail.com",
	'Password'   =>   "dhtlqtkqjsrkdptj",
	'setFrom'    =>   "6ave54street@gmail.com",
	'isHtml'     =>   true,
);

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

$TO_arr = explode(",", $TO);
$CC_arr = explode(",", $CC);
$BCC_arr = explode(",", $BCC);

foreach ($TO_arr as $addr) { $mail->addAddress($addr); }
foreach ($CC_arr  as $addr) { $mail->addCC($addr); }
foreach ($BCC_arr as $addr) { $mail->addBCC($addr); }


/*
 * Day 21 setup
 * 
 *
 */

$startDate	= "2020-06-14";

$Day0 		= strtotime($startDate);
$DayN		= strtotime(date("Y-m-d"));
$N		= ($DayN - $Day0)/60/60/24;

/* 
echo "Day 0 - " . date('Y-m-d', $Day0) . "\n";
echo "Day N - " . date('Y-m-d', $DayN) . "\n";
echo "Day " . $N . "\n";
 */

$DaySubject	= "Day " . $N . " - " . date("l, j F Y");



/*
 * Email Subject and Body
 * 
 *
 */


$daycont		= file_get_contents("Day ".$N.".htm");
$daycont		= str_replace("11:59pm", date("l") . " 11:59pm", $daycont);
$Subject		= "Day " . $N;
$Body			= $DaySubject . "<br><br>" . $daycont;


$mail->Subject =  	$Subject;
$mail->Body =        	$Body;
$mail->send();
?>
