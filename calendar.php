 <?php 
 include 'wp-load.php';
 
 
$user_id = get_current_user_id();

//echo currentip_address();
 ?>



 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<style>
/* calendar */
table.calendar		{ border-left:1px solid #999; }
tr.calendar-row	{  }
td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
td.calendar-day:hover	{ background:#eceff5; }
td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
/* shared */
td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }

.timeslot{  background: #999 none repeat scroll 0 0;  color: #ffffff; font-weight:bold;  margin: 6px;  padding: 4px 9px 3px 10px; cursor:pointer;  }
#id_times { padding-top:30px; }

.calendar-nav-head{  background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
</style>

<script type="text/javascript">

function available_timeslots(valday,valmonth,valyear)
{
	
	var gDay=valday;
	var gMonth=valmonth;
	var gYear=valyear;
	
	if(gDay!='00' && gMonth!='00' && gYear!='0000')
	{
		//alert('DAY::'+gDay+'==MONTH::'+gMonth+'==YEAR::'+gYear);
		$.ajax({
			url:'http://srinode50/health_wellness/check_availability.php?servicetype=check_availability',
			type:'POST',
			data:{gDay:gDay,gMonth:gMonth,gYear:gYear},
			success:function(response)
			{
			
			
				document.getElementById('id_times').innerHTML=response ;
				
			},
			error:function(error)
			{
				//$("#g_age").val('0');
				//document.getElementById('ag_age').innerHTML='';
			}
		});
	}	
}





function month_pre_next(valmonth,valyear,valtype)
{


	
	var gType=valtype;
	var gMonth=valmonth;
	var gYear=valyear;
	
	if(valmonth!='00' && valyear!='0000' && valtype!='0')
	{
		//alert('DAY::'+gDay+'==MONTH::'+gMonth+'==YEAR::'+gYear);
		$.ajax({
			url:'http://srinode50/health_wellness/check_availability.php?servicetype=displaycalendar',
			type:'POST',
			data:{gType:gType,gMonth:gMonth,gYear:gYear},
			success:function(response)
			{
						
				document.getElementById('booking_calender').innerHTML=response ;
				
			},
			error:function(error)
			{
			//	$("#g_age").val('0');
			//	document.getElementById('ag_age').innerHTML='';
			}
		});
	}	

}



function booking_time(valdate,valhour)
{

document.getElementById('booking_type').style.display="inline";


document.getElementById('item_name').value=valdate+' '+valhour+' Booking';
var userid=document.getElementById('userid').value;

document.getElementById('custom').value=userid+'@@@'+valdate+'@@@'+valhour;


}


function valid_payment()

{

	var userid=document.getElementById('userid').value;

	if(userid=='')
	{
		alert('You need to login for booking the shedule');
		return false;
	}

	
	
}


function bookingtype(val)
{

	if(val=='remote')
	{
		document.getElementById('paymentform').style.display="inline";

		document.getElementById('bookingform').style.display="none";
	}
	else if(val=='local')
	{
		document.getElementById('paymentform').style.display="none";

		document.getElementById('bookingform').style.display="inline";
	}
	else
	{
		document.getElementById('paymentform').style.display="none";

		document.getElementById('bookingform').style.display="inline";
	}


	
}



</script>
<?php 

/* draws a calendar */
function draw_calendar($month,$year){


	/* draw table */



    $monthName = date("F", mktime(0, 0, 0, $month, 10)); 

	$calendar= '<table cellpadding="0" cellspacing="0" class="calendar">';
	
	$calendar.= '<tr class="calendar-row"><td   onclick="month_pre_next(\''.$month.'\',\''.$year.'\',\'prevm\')" class="calendar-nav-head">Prev</td>  <td colspan="5" class="calendar-nav-head">'. $year . '   '.$monthName .'</td>   <td  onclick="month_pre_next(\''.$month.'\',\''.$year.'\',\'nextm\')" class="calendar-nav-head">Next</td></tr>';
	

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

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

	$today_date=date('d');
	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
	
	$style_today='';
	if($today_date==$list_day)
	{
	$style_today='style="color:#ff0000"';
	}
		$calendar.= '<td  class="calendar-day" onclick="available_timeslots('.$list_day.','.$month.','.$year.')">';
			/* add in the day number */
			$calendar.= '<div '.$style_today.' class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			$calendar.= str_repeat('<p> </p>',2);
			
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

?>



<div id="booking_calender">

<?php 



echo '<h2>'.date("F").'   '.date("Y").'</h2>';
echo draw_calendar(date("m"),date("Y"));



?>

</div>


<div id="id_times"></div>



<div id="booking_type"  style="display:none">

<label id="email-label">Select Booking Type</label> <br/>

<input type="hidden" name="userid"  id="userid" value="<?php echo $user_id; ?>">

<input  onclick="bookingtype(this.value)"  type="radio" name="type_booking" id="type_booking" value="local" checked>  Local Bookining - You can pay later  <br/>

<input  onclick="bookingtype(this.value)"  type="radio" name="type_booking" id="type_booking" value="remote">  Remote Booking- You need to Pay now. 

</div>



<div  id="paymentform" style="display:none">
<form name="payment_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" onSubmit="return valid_payment();">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="elango.php-developer@gmail.com">
<input type="hidden" name="item_name" id="item_name" value="Booking">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?php echo get_bloginfo('url'); ?>/payment_success.php">
<input type="hidden" name="cancel_return" value="<?php echo get_bloginfo('url'); ?>/payment_failure.php">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="notify_url" value="<?php echo get_bloginfo('url'); ?>/payment_notify.php">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" id="amount" value="<?php echo get_option( 'booking_amount', false ) ?>">
<input type="hidden" name="custom" id="custom" value="">
<br />  

Booking Cost <?php echo get_option( 'booking_amount', false ) ?>
          
<input type="submit" id="submitpaypale"  border="0" name="submit" value = "Book Now" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
</div>


<div  id="bookingform" style="display:none">
<form name="booking_form" action="" onSubmit="return valid_payment();">
<input type="hidden" name="item_name" id="item_name" value="Booking">
<input type="hidden" name="custom" id="custom" value="">
<br />            
<input type="submit" id="booknow"  border="0" name="submit" value = "Book Now" alt="Book Now">
</form>
</div>

