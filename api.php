<?PHP

$mysql = mysql_connect("localhost","root","") or die(mysql_error());

$db = mysql_select_db("eventrack");

$sql="SELECT OLYMP_STATION, DEPTIME, DEP_TO, PLAT FROM `Eventrack Static TT Data`";

$result = mysql_query($sql);

date_default_timezone_set("Europe/London");

//Current Time 
//The Train's Time
//If the Train's Time is less than 2 hours in the future, then it sends the train

$currentTime = date('H:i');

function stringrpl($x,$r,$str) 
{ 
$out = ""; 
$temp = substr($str,$x); 
$out = substr_replace($str,"$r",$x); 
$out .= $temp; 
return $out; 
} 


$output="";

$output.= ('[');

	while($out=mysql_fetch_assoc($result)){

	$trainTime = strToTime(stringrpl(2,":",$out['DEPTIME']));
	
	if ($out['DEPTIME'] == "null"){
	continue;
	}
	
	//echo $out['DEPTIME'];
	
	$allowTrain = False;
	//echo " ". strToTime(stringrpl(2,":",str_replace(" ","",$out['DEPTIME'])));
	
		if (strToTime(stringrpl(2,":",$out['DEPTIME'])) - strToTime($currentTime) < 7200){
			if (strToTime(stringrpl(2,":",$out['DEPTIME'])) - strToTime($currentTime) > 0){
				$allowTrain = True;
			}
		}

	if ($allowTrain == True){
	
			$output.= '{';

			$output.= '"OLYMP_STATION":"'.$out['OLYMP_STATION'].'",';
			$output.= '"DEPTIME":"'.stringrpl(2,":",$out['DEPTIME']).'",';
			$output.= '"DEP_TO":"'.$out['DEP_TO'].'",';
			$output.= '"PLAT":"'.$out['PLAT'].'"';

			$output.= '},';
		}
	}
	
$output = substr($output, 0, -1);
$output.= (']');

echo $output;
?>