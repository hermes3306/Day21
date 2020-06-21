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

$props   = parse_ini_file($mbox_home . '/0620.ini');


$mail   = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPDebug        =       0;
$mail->ContentType      =       "text/html";
$mail->CharSet          =       "UTF-8";
$mail->Encoding         =       "base64";

$mail->Host             =       $props['Host'];
$mail->Port             =       $props['Port'];
$mail->SMTPSecure       =       $props['SMTPSecure'];
$mail->SMTPAuth         =       $props['SMTPAuth'];
$mail->Username         =       $props['Username'];
$mail->Password         =       $props['Password'];

$mail->setFrom          ($props['setFrom']);
$mail->isHTML           ($props['isHtml']);

foreach ($props['To']  as $addr) { $mail->addAddress($addr); }
foreach ($props['Cc']  as $addr) { $mail->addCC($addr); }
foreach ($props['Bcc'] as $addr) { $mail->addBCC($addr); }

$Day0           = $props['Day0'];
$Day0           = strtotime($Day0);
$DayN           = strtotime(date("Y-m-d"));
$N              = ($DayN - $Day0)/60/60/24;



/*
 * Email Subject and Body
 * 
 *
 */



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

for($i=1;$i<=21;$i++) {
	$DaySubject     = "<h2><string>Day " . $i . " - " . date("l, j F Y") . "</strong></h2>";
	$url	 	= "<a href='" . $urls[$i] . "'>" . $urls[$i] . "</a>"  ;
	$daycont	= file_get_contents($mbox_home . "/cont1/Day".$i.".htm");
	$daycont        = str_replace("11:59pm", date("l") . " 11:59pm", $daycont);
	$mail->Subject 	= "Day " . $i;
	$mail->Body    = $DaySubject . "<br><br>" . $daycont . "<br><br>" . $url;
	$mail->send();
	echo "Day " . $i . " Sent!\n";
}

?>
