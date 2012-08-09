<?PHP

$mysql = mysql_connect("localhost","root","") or die(mysql_error());

$db = mysql_select_db("eventrack");

$sql="SELECT OLYMP_STATION, DEPTIME, DEP_TO, PLAT FROM `Eventrack Static TT Data`";

$result = mysql_query($sql);

//$STARTTIME=date('Hi');

$STARTTIME = '0000';

//var_dump($STARTTIME);

$starttime = strToMins($STARTTIME);
$preendtime = strToMins($STARTTIME) + 120;
	
$preendtime;
$starttime;

$output="";

$output.= ('[');

while($out=mysql_fetch_assoc($result)){

$testtime = $out['DEPTIME'];
	$allowtrain = false;
	if ($starttime < strToMins($testtime) && $testtime < $preendtime) {
		$allowtrain = true;
	} else {
		if ($preendtime > 1440) {
			$postendtime = $preendtime - 1440;
			if (strToMins($testtime) < $postendtime){
				$allowtrain = true;
			}
		}
	}
	if(strToMins($testtime)==0) $allowtrain = false;


if($allowtrain === true){	
$output.= '{';

$output.= '"OLYMP_STATION":"'.$out['OLYMP_STATION'].'",';
$output.= '"DEPTIME":"'.strToMins($out['DEPTIME']).'",';
$output.= '"DEP_TO":"'.$out['DEP_TO'].'",';
$output.= '"PLAT":"'.$out['PLAT'].'"';

$output.= '},';
}
}
$output = substr($output, 0, -1);
$output.= (']');

echo $output;

function strToMins($str){
	$hours = intval($str[0] . $str[1]) * 60;
	$minutes = intval($str[2] . $str[3]);
	return $hours + $minutes;
}

?>