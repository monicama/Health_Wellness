<?php 
	include 'wp-load.php';


	$timezone_current= $_POST['usertimezone'];
	
	/***Find hrs of timezone using its array***/
	$zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -9.00, 'America/Los_Angeles' => -8.00, 'America/Denver' => -7.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -5.00, 'America/Halifax' => -4.00,'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => +5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Singapore' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
	
	$key = $zonelist[$timezone_current];
	$offset = round($key, 2);
	/***Find hrs of timezone using its array***/
	
	
	date_default_timezone_set($timezone_current);

	///////////////booking time START///////////////
	if($_REQUEST['servicetype'] && $_REQUEST['servicetype']=='check_availability')
	{

		$user_timezone=date_default_timezone_get(); // Getting user timezone
		
		$admin_timezone=get_option('r_timezone_string'); // Getting admin timezone
		

		$gDay=$_POST['gDay'];

		$gMonth=$_POST['gMonth'];

		$gYear=$_POST['gYear'];

		// Function to add 0 before month and date 
		$gMonth=($gMonth<10) ? '0'.$gMonth : $gMonth; 

		$gDay=($gDay<10) ? '0'.$gDay : $gDay;

		$bookdate=$gYear.'-'.$gMonth.'-'.$gDay;
		
		global $wpdb;

		/////////check previous time////////

		$curdate=date('Y-m-d');

		if($bookdate==$curdate)

		{
		 $curdtime=date('H');
			
			for($k=1; $k<=24; $k++)
			{
				
				if($curdtime>=$k)
				{
					   
				$kk=$k.':00';
				$past_date[]=date('h:i a',strtotime($kk));
			  
			   
				}
			  
			
			}


		}


		//print_r($past_date);
		////check leave START////

		$leavecount = $wpdb->get_var( "select count(*) from ".$wpdb->prefix."booking_leave where l_date='".$bookdate."'" );

		 
		//$q="select * from ".$wpdb->prefix."booking where b_date='".$bookdate."'";


		$q="select * from ".$wpdb->prefix."booking where FIND_IN_SET('".$bookdate."',b_date)"; // check the booked time slots

		$bookinginfo = $wpdb->get_results($q, ARRAY_A);

		foreach($bookinginfo as $bookinginfo_val)
		{
				
		 $bookinginfo_time[]=$bookinginfo_val['b_admin_booking_time'];

		}
		
		$bookinginfo_time_imp=@implode(',',$bookinginfo_time);
		$bookinginfo_time_exp=@explode(',',$bookinginfo_time_imp);
		for($i=0; $i<count($bookinginfo_time_exp) ;$i++)
		{
			$booking_date=$bookinginfo_time_exp[$i];	
			if($booking_date)  
			{
				$date = new DateTime($booking_date, new DateTimeZone($admin_timezone));
				$date->format('Y-m-d h:i a');		  
				$date->setTimezone(new DateTimeZone($user_timezone));
				$bookingdate=$date->format('Y-m-d');
				if($bookdate==$bookingdate)
				{
					if($date->format('i')!='00')
					{
						$date->modify("+30 minutes");		   			   		  
						$bookingdatetime[]=$date->format('h:i a');	
						$date->modify("-60 minutes");
						$bookingdatetime[]=$date->format('h:i a');	
					}
					else 
					{
						$bookingdatetime[]=$date->format('h:i a');	
					}
					//$bookingdatetime[]=$date->format('h:i a');	
				}	
			}
		}
			
		//print_r($bookingdatetime);

			  

		$timesarray=array('09:00 am','10:00 am','11:00 am','12:00 pm','01:00 pm','02:00 pm','03:00 pm','04:00 pm','05:00 pm','06:00 pm','07:00 pm','08:00 pm','09:00 pm','10:00 pm','11:00 pm');

		if(count($bookingdatetime)) // Get the count of booked time slots
		{
			$timesarray=@array_diff($timesarray, $bookingdatetime);
		}
		if(count($past_date))
		{
			$timesarray=@array_diff($timesarray, $past_date);
		}
		if(count($timesarray)=='0') // If no time slots available 
		{
			echo '<label style="color: #ff0000; font-family: Lato-Bold;  font-size: 24px;">Booking not available.</label>';
		}
		else
		{
			echo '<label style="color: #2d746b; font-family: Lato-Bold;  font-size: 24px;">Available Appointments (in '.$timezone_current.' [GMT '.$offset.'hrs])</label><div class="time-holder">';
		}

		$times='';
		foreach($timesarray as $timesarray_val)
		{

		//$times.='<span class="timeslot"  id="timeslot'.$timesarray_val.'" onclick="booking_time(\''.$bookdate.'\',\''.$timesarray_val.'\')">'.$timesarray_val.'</span>';

			  $times.=' <div class="time-each"  onclick="booking_time(\''.$bookdate.'\',\''.$timesarray_val.'\')">';
										   $times.=' <label  id="timeslot'.$timesarray_val.'" class="timeslot"  for="check-time1">'.$timesarray_val.'</label>';
									 $times.='   </div>';
										
		}


		if($leavecount)
		{
		$times='<label style="color: #ff0000; font-family: Lato-Bold;  font-size: 24px;">Booking not available.</label>';
		}

		 $times.='</div>';
		 
		echo $times;

		exit;
	}

	////////////////////////Booking time END//////////


	////////////////Calendar Display START///////////////////

	if($_REQUEST['servicetype'] && $_REQUEST['servicetype']=='displaycalendar')
	{

	//echo date_default_timezone_get();

	$gmonth=$_POST['gMonth'];

	$gYear=$_POST['gYear'];

	$gType=$_POST['gType'];

	if($gType=='prevm')
	{
	$gmonth=$_POST['gMonth']-1;
	}
	else if($gType=='nextm')
	{
	$gmonth=$_POST['gMonth']+1;
	}


	if($gmonth>12)
	{
	$gmonth=1;
	$gYear=$gYear+1;
	}

	if($gmonth<1)
	{
	$gmonth=12;
	$gYear=$gYear-1;
	}

	/* draws a calendar */
	function draw_calendar($month,$year){
		/* draw table */

		$current_month=strtotime(date("Y-m")).'==';
		
		$calendar_month=strtotime($year.'-'.$month);    

		$monthName = date("F", mktime(0, 0, 0, $month, 10));
	 
		$calendar= '<table cellpadding="0" cellspacing="0" class="calendar">';
		
		if($current_month<$calendar_month)
		$calendar.= '<tr class="calendar-row"><td  style="width: 28px;cursor: pointer;" onclick="month_pre_next(\''.$month.'\',\''.$year.'\',\'prevm\')" class="calendar-nav-head"><<</td>  <td colspan="5" class="calendar-nav-head">'. $year . '   '.$monthName .'</td>   <td  style="width: 28px;cursor: pointer;"  onclick="month_pre_next(\''.$month.'\',\''.$year.'\',\'nextm\')" class="calendar-nav-head">>></td></tr>';
		else 
		$calendar.= '<tr class="calendar-row"><td  style="width: 28px;"  class="calendar-nav-head"><<</td>  <td colspan="5" class="calendar-nav-head">'. $year . '   '.$monthName .'</td>   <td  style="width: 28px;cursor: pointer;"  onclick="month_pre_next(\''.$month.'\',\''.$year.'\',\'nextm\')" class="calendar-nav-head">>></td></tr>';
		

		/* table headings */
		$headings = array('Su','Mo','Tu','We','Th','Fr','Sa');
		$calendar.= '<tr class="calendar-head"><td >'.implode('</td><td>',$headings).'</td></tr>';

		/* days and weeks vars now ... */
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		

		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();

		/* row for week one */
		$calendar.= '<tr class="calendar-row">';

		/* print "blank" days until the first of the current week */
		for($x = 0; $x < $running_day; $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
			$days_in_this_week++;
		endfor;

		
		/* keep going with days.... */
		 for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		
		 $style_today='';	
		 
		 $currentday=strtotime(date("Y-m-d"));
		
		 $calendarday=strtotime($year.'-'.$month.'-'.$list_day);
		 
		 if($currentday==$calendarday)
		 
		 {
		 $style_today='background: #7fc6bd none repeat scroll 0 0;';
		 } else if($currentday>$calendarday) {
				
		 $style_today='background: #C8C8C8 none repeat scroll 0 0;border: 1px solid #fff;';
		 
		 }
		
		
		 
			 if($currentday<=$calendarday)	
			 $calendar.= '<td  id="today_date" style="cursor: pointer; '.$style_today.'" class="calendar-day" onclick="change_datepicker(this);setdate_timezone('.$list_day.','.$month.','.$year.');available_timeslots('.$list_day.','.$month.','.$year.')">';
			 else 
			 $calendar.= '<td   style="'.$style_today.'"   class="calendar-day">';
			 
				/* add in the day number */
				$calendar.= '<div  class="day-number">'.$list_day.'</div>';

				/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
				//$calendar.= str_repeat('<p> </p>',2);
				
			$calendar.= '</td>';
			if($running_day == 6):
				$calendar.= '</tr>';
				if(($day_counter+1) != $days_in_month):
					$calendar.= '<tr class="calendar-row">';
				endif;
				$running_day = -1;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;

		/* finish the rest of the days in the week */
		if($days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar.= '<td class="calendar-day-np"> </td>';
			endfor;
		endif;

		/* final row */
		$calendar.= '</tr>';

		/* end the table */
		$calendar.= '</table>';
		
		/* all done, return result */
		return $calendar;
	}


	$gmonth=sprintf('%02d', $gmonth);

	$monthName = date("F", mktime(0, 0, 0, $gmonth, 10)); 
	 
	//echo '<h2>'.$monthName.'   '.$gYear.'</h2>';
	echo '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all"><div class="ui-datepicker-title"><span class="ui-datepicker-month">'.$monthName.'</span>&nbsp;<span class="ui-datepicker-year">'.$gYear.'</span></div></div>';

	echo draw_calendar($gmonth,$gYear);

	exit;

	}
	//////////////Calendar Display END/////////////
	if($_REQUEST['servicetype'] && $_REQUEST['servicetype']=='currencyconversion')
	{
		
		$amount=$_POST['amount'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		
		 $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
		$data = file_get_contents($url);
		preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
		$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
		echo  round($converted, 2);
	}

	if($_REQUEST['servicetype'] && $_REQUEST['servicetype']=='currencyconversion_single')
	{
		
		$amount=$_POST['amount'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		
		 $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
		$data = file_get_contents($url);
		preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
		$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
		echo  round($converted, 2);
	}

	if($_REQUEST['servicetype'] && $_REQUEST['servicetype']=='totalshiftcost')
	{

		$amount=$_POST['amount'];
		$from=$_POST['from'];
		$to=$_POST['to'];
		$shiftcount=$_POST['shiftcount'];
		
		$total_amount=$amount*$shiftcount;
		
		$url  = "https://www.google.com/finance/converter?a=$total_amount&from=$from&to=$to";
		$data = file_get_contents($url);
		preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
		$converted = preg_replace("/[^0-9.]/", "", $converted[1]);
		echo  round($converted, 2);
		
		
	}
?>