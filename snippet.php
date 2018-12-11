<?php
$calendar=isset($calendar)?$calendar:'.calendar';
$times=isset($times)?$times:'.booktimes';
$res=$modx->db->select('properties',$modx->getFullTableName('site_modules'),'name="booking"');
while($row=$modx->db->getRow($res))$opt=json_decode($row['properties'],true);
$holidays=$opt['holidays'][0]['value'];
$weekends=$opt['weekends'][0]['value'];
$plusdays=$opt['plusdays'][0]['value'];
$intervals=$opt['intervals'][0]['value'];
$scripts='
<script src="assets/modules/booking/pickmeup.min.js"></script>
<script>
	var MODX_SITE_URL="'.MODX_SITE_URL.'";
	var holidays = "'.$holidays.'";
	var weekends = "'.$weekends.'";
	var plusdays = '.$plusdays.'+0;
	var intervals = "'.$intervals.'";
	var calendars = 1;
	var manager=false;
</script>
<script src="assets/modules/booking/booking.js"></script>';
$styles='
	<link rel="stylesheet" href="assets/modules/booking/pickmeup.css" type="text/css">';
$modx->setPlaceholder('booking_scripts',$scripts);
$modx->setPlaceholder('booking_styles',$styles);
$modx->setPlaceholder('booking_dates','<div class="calendar"></div>');
$modx->setPlaceholder('booking_times','<div class="booktimes"></div>');
return;
