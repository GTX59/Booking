<?php
//@ini_set("display_errors","0");
//error_reporting(0);
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])&&strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest'){
	define('MODX_API_MODE', true);
	include_once ('../../../index.php');
	if(isset($_POST['setup'])){
		if(!isset($_SESSION['mgrValidated']))die('Go away!');
		$modx->db->query('CREATE TABLE IF NOT EXISTS `'.$modx->db->config['table_prefix'].'_booking'.'` (`id` int(11) NOT NULL AUTO_INCREMENT, `date` text,`value` text, PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
		$setup=file_get_contents('setup.json');
		$o=$modx->db->update(array('properties'=>$setup),$modx->getFullTableName('site_modules'),'name="Booking"');
		if($o)die('Успешно!');
		die('Что-то пошло не так...');
	}
	if(isset($_POST['date'])){
		$date = (int)$_POST['date'];
		$res = $modx->db->select('value',$modx->getFullTableName('booking'),'date="'.$date.'"');
		while($row=$modx->db->getRow($res))$val=$row['value'];
		die($val);
	}
	if(isset($_POST['record'])){
		if(!isset($_SESSION['mgrValidated']))die('Go away!');
		$tbl=$modx->db->config['table_prefix'].'booking';
		$sql='CREATE TABLE IF NOT EXISTS `'.$tbl.'` (`id` int(11) NOT NULL AUTO_INCREMENT, `date` text,`value` text, PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		$modx->db->query($sql);
		$date = (int)$_POST['record'];
		$arr=array('date'=>$date,'value'=>$_POST['value']);
		$modx->db->insert($arr,$modx->getFullTableName('booking'));
		$res = $modx->db->select('value',$modx->getFullTableName('booking'),'date="'.$date.'"');
		while($row=$modx->db->getRow($res))$val=$row['value'];
		die($val);
	}
}
if(!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE !== true || ! $modx->hasPermission('exec_module')) {
    header('HTTP/1.0 404 Not Found');
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Бронирование</title>
    <link rel="stylesheet" type="text/css" href="media/style/default/style.css" />
	<link rel="stylesheet" type="text/css" href="<?=MODX_SITE_URL?>/assets/modules/booking/pickmeup.css" />
</head>
<body>
<script>if ( 3 == '4') {document.body.className='darkness';}</script>

<h1>
    <i class="fa fa-file-text"></i>Бронирование
</h1>

<div id="actions">
    <div class="btn-group">
        <span id="setup" class="btn btn-success">
            <i class="fa fa-times-circle"></i><span>Setup</span>
        </span>
		<a id="Button1" class="btn btn-success" href="javascript:;" onclick="window.location.href='index.php?a=106';">
            <i class="fa fa-times-circle"></i><span>Закрыть</span>
        </a>
    </div>
</div>
<div class="wrapper">
	<div class="container-fluid" style="overflow-x:hidden;">
	
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<h2>Дата</h2>
				<div class="calendar"></div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<h2>Время</h2>
				<div class="booktimes"></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="media/script/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?=MODX_SITE_URL?>/assets/modules/booking/pickmeup.min.js"></script>
<script>
	var MODX_SITE_URL='<?=MODX_SITE_URL?>';
	var holidays = '<?=$holidays?>';
	var weekends = '<?=$weekends?>';
	var plusdays = <?=$plusdays?>+0;
	var intervals = '<?=$intervals?>';
	var calendars = 3;
	var manager=true;
</script>
<script type="text/javascript" src="<?=MODX_SITE_URL?>/assets/modules/booking/booking.js"></script>
</body>
</html>
