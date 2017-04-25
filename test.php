<?php
/*$date = new DateTime('2015-08-12 05:00 pm', new DateTimeZone('UTC'));
echo $date->format('Y-m-d h:i:s aP') . "<br/>";

echo strtotime($date->format('Y-m-d h:i:s a')). "<br/>";

$date->setTimezone(new DateTimeZone('Asia/Calcutta'));
echo $date->format('Y-m-d h:i:s aP') . "<br/>";


echo date('Y-m-d h:i:s a','1439391600'). "<br/>";

$date->setTimezone(new DateTimeZone('Asia/Singapore'));
echo $date->format('Y-m-d h:i:s aP') . "<br/>";

echo date('Y-m-d h:i:s a','1439391600'). "<br/>";


 echo $gmdateval=gmdate("Y-m-d h:i:s a",strtotime('2015-08-12 05:00 pm'));

 */

 
 
 
 $date = new DateTime('2015-8-13 05:00 pm', new DateTimeZone('Asia/Calcutta'));
echo $date->format('Y-m-d h:i:s aP') . "<br/>";

$date->setTimezone(new DateTimeZone('Asia/Singapore'));
echo $date->format('Y-m-d h:i:s aP') . "<br/>";



 echo '=================';
 
 
 $date = new DateTime('2015-08-12 04:31:58 pm', new DateTimeZone('UTC'));
 
function get_timee($country,$city)
{
	$country = str_replace(' ', '', $country);
	$city = str_replace(' ', '', $city);
	$geocode_stats = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$city+$country,&sensor=false");
	$output_deals = json_decode($geocode_stats);
	$latLng = $output_deals->results[0]->geometry->location;
	$lat = $latLng->lat;
	$lng = $latLng->lng;    
	$google_time = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=1331161200");
	$timez = json_decode($google_time);

	$d = new DateTime("now", new DateTimeZone($timez->timeZoneId));
	return  $d->format('H:i:s');
}


function get_time_difference($time1, $time2)
{
    $time1 = strtotime("1/1/1980 $time1");
    $time2 = strtotime("1/1/1980 $time2");
    
    if ($time2 < $time1)
    {
    
    
        $time2 = $time2 + 86400;
    }
    
       return date("H:i:s", strtotime("1980-01-01 00:00:00") + ($time2 - $time1));
    
}  
	

echo $OtherCountry=get_timee("dubai","");
 $MyCountry=get_timee("India","");
echo "Time difference: ".get_time_difference($MyCountry, $OtherCountry)." hours<br/>"; 
	




 
 




?>









