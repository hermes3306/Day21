<?php
echo "
<html>
<body>
<table border='0' align='left'>
<tr>
<td>Name</td>
<td>Day</td>
<td>Date</td>
<td>Time</td>
<td>Status</td>
</tr> ";

$db     =       new SQLite3("/home/pi/code/Day21Inst/Day21.db");

$res = $db->query('SELECT * FROM Day21');
while ($row = $res->fetchArray()) {
                echo "<tr>	<td>{$row['name']}</td> 
			  	<td>{$row['day']}</td>
			  	<td>{$row['cr_date']}</td>
			  	<td>{$row['cr_time']}</td>
				<td>{$row['status']}</td> </tr>";
}
$db->close();
echo "</table>
</body>
</html>";

?>
