<?PHP

$mysql = mysql_connect("localhost","root","") or die(mysql_error());

$db = mysql_select_db("eventrack");

$sql="SELECT OLYMP_STATION, DEPTIME, DEP_TO, PLAT FROM `Eventrack Static TT Data`";

$result = mysql_query($sql);

$STARTTIME='2359'; 

$starttime = strToMins($STARTTIME);
$preendtime = strToMins($STARTTIME) + 120;
	
echo $preendtime;
echo $starttime;

echo ('[');

while($out=mysql_fetch_assoc($result)){

$testtime = '0002';

	if ($starttime < strToMins($testtime) && $testtime < $preendtime) {
		echo 'Allow Train';
	} else {
		if ($preendtime > 1440) {
			$postendtime = $preendtime - 1440;
			if (strToMins($testtime) < $postendtime){
				echo 'Allow Train';
			}
		}
	}
	
echo '{';

echo '"OLYMP_STATION":"'.$out['OLYMP_STATION'].'",';
echo '"DEPTIME":"'.$out['DEPTIME'].'",';
echo '"DEP_TO":"'.$out['DEP_TO'].'",';
echo '"PLAT":"'.$out['PLAT'].'"';

echo '},';

}

echo (']');

function strToMins($str){
	$hours = intval($str[0] . $str[1]) * 60;
	$minutes = intval($str[2] . $str[3]);
	return $hours + $minutes;
}

?>