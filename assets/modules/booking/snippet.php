<?php
$calendar=isset($calendar)?$calendar:'.calendar';
$times=isset($times)?$times:'.booktimes';
$res=$modx->db->select('properties',$modx->getFullTableName('site_modules'),'name="booking"');
while($row=$modx->db->getRow($res))$opt=json_decode($row['properties'],true);
$holidays=$opt['holidays'][0]['value'];
$weekends=$opt['weekends'][0]['value'];
$plusdays=$opt['plusdays'][0]['value'];
$intervals1=$opt['intervals1'][0]['value'];
$intervals2=$opt['intervals2'][0]['value'];
$intervals3=$opt['intervals3'][0]['value'];
$intervals4=$opt['intervals4'][0]['value'];
$intervals5=$opt['intervals5'][0]['value'];
$intervals6=$opt['intervals6'][0]['value'];
$intervals7=$opt['intervals7'][0]['value'];

$scripts='
<script src="assets/modules/booking/pickmeup.min.js"></script>
<script>
	var MODX_SITE_URL="'.MODX_SITE_URL.'";
	var holidays = "'.$holidays.'";
	var weekends = "'.$weekends.'";
	var plusdays = parseInt('.$plusdays.');
	let intervals = [];
	intervals[1] = "'.$intervals1.'";
	intervals[2] = "'.$intervals2.'";
	intervals[3] = "'.$intervals3.'";
	intervals[4] = "'.$intervals4.'";
	intervals[5] = "'.$intervals5.'";
	intervals[6] = "'.$intervals6.'";
	intervals[0] = "'.$intervals7.'";
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
