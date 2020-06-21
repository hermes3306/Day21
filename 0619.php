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

$startDate	= "2020-06-19";

$Day0 		= strtotime($startDate);
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

$DaySubject	= "Day " . $N . " - " . date("l, j F Y");

$urls = array(
	'1'=> "https://www.youtube.com/watch?v=cfxs_WxswWg",
	'2'=> "https://www.youtube.com/watch?v=T8xl3dR70Wo",
	'3'=> "https://www.youtube.com/watch?v=aIILihl4iio",
	'4'=> "https://www.youtube.com/watch?v=YXmW1WwPALA",
	'5'=> "https://www.youtube.com/watch?v=eul8ae3zi3c",
	'6'=> "https://www.youtube.com/watch?v=XdrFzwZGhf8",
	'7'=> "https://www.youtube.com/watch?v=LYzvXOWv7xE",
	'8'=> "https://www.youtube.com/watch?v=ZBYjoQZxFbg",
	'9'=> "https://www.youtube.com/watch?v=m_2qPQbkG9c",
	'10'=> "https://www.youtube.com/watch?v=ivWwg3_fm-c",
	'11'=> "https://www.youtube.com/watch?v=gZeijoFNA5o",
	'12'=> "https://www.youtube.com/watch?v=NbfDxK9JpJU",
	'13'=> "https://www.youtube.com/watch?v=GpDffAW4PZ8",
	'14'=> "https://www.youtube.com/watch?v=8SmtsqmD9Y0",
	'15'=> "https://www.youtube.com/watch?v=uuc6fV9cN2g",
	'16'=> "https://www.youtube.com/watch?v=CRVMX4A1Sp4",
	'17'=> "https://www.youtube.com/watch?v=ufByNb-8etQ",
	'18'=> "https://www.youtube.com/watch?v=3OZVy0vZ6Ds",
	'19'=> "https://www.youtube.com/watch?v=rok9-7a8O64",
	'20'=> "https://www.youtube.com/watch?v=Fzpj12yMytg,",
	'21'=> "https://www.youtube.com/watch?v=a-9VqEJhSj4"
);



/*
 * Email Subject and Body
 * 
 *
 */

$url			= $urls[$N] ;
$daycont		= file_get_contents($mbox_home . "/Day ".$N.".htm");
$daycont		= str_replace("11:59pm", date("l") . " 11:59pm", $daycont);
$Subject		= "Day " . $N;
$Body			= $DaySubject . "<br><br>" . $daycont . $url;


$mail->Subject =  	$Subject;
$mail->Body =        	$Body;
/* $mail->addAttachment($mbox_home . "/Day ".$N.".htm"); */
$mail->send();
?>
