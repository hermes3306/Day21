<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mbox_home  =   getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
require     $mbox_home . '/vendor/autoload.php';

/*
 * Email properties
 * 
 */

if($argc < 2) {
	echo "usage: php Day21.php sample.ini\n";
	exit(-1);
}

$props	 = parse_ini_file($mbox_home . "/" . $argv[1] ); 

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

if($N <0 or $N > 21) {
	echo "Not started or finished! \n";
	echo "Day # is " . $N . " \n";
	exit();
}

$DaySubject	= "<h2><string>Day " . $N . " - " . date("l, j F Y") . "</strong></h2>";

$urls = array();
foreach ($props['urls']  as $url) { 
	array_push($urls, $url);
}

/*
 * Email Subject and Body
 * 
 *
 */
if($N == 0) {
	$url 	= "<img src='" .$urls[$N] . "'/>" ;
} else {
	$url                    = "<a href='" . $urls[$N] . "'>" . $urls[$N] . "</a>"  ;
}

$daycont                = file_get_contents($mbox_home . "/www/cont1/Day".$N.".htm"); 
/*$daycont                = file_get_contents("http://ez-hub.club/contL/Day".$N.".htm"); */

$daycont		= str_replace("{{Today}}", date("l, j F Y"), $daycont);
$daycont		= str_replace("{{Day}}", date("l"), $daycont);
$daycont		= str_replace("{{DayN}}", "Day ".$N , $daycont);

$Subject                = "Day " . $N . " for " . $props['Name'];
$Body                   = $daycont . "<br><br>" . $url; 

$mail->Subject =  	$Subject;
$mail->Body =        	$Body;
$mail->send();

echo "" . date("m-d-Y G:i:s") . " - Day " . $N . " for " . $props['Name'] . " sent!\n" ;

$db     =       new SQLite3($mbox_home . "/Day21.db");
$db->exec("CREATE TABLE IF NOT EXISTS Day21 (
	name    text,
	day     integer,
	status  text,
	created datetime,
	cr_date text,
	cr_time text)");

$stmt = $db->prepare("INSERT INTO Day21 (name, day, status, cr_date, cr_time, created) 
			VALUES (:name, :day, :status, :cr_date, :cr_time, current_timestamp)");
$stmt->bindValue(':name', $props['Name']);
$stmt->bindValue(':day', $N );
$stmt->bindValue(':status', 'OK');
$stmt->bindValue(':cr_date', date('Y-m-d'));
$stmt->bindValue(':cr_time', date('G:i:s'));
$stmt->execute();
$db->close();



?>
