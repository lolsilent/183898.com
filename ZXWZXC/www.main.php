<?php
#!/usr/local/bin/php
/*
###_______________-=TheSilenT.CoM=-_______________###
Project name	: Project name
Script name	: Script name
Version		: 1.00
Release date	: 3/16/2018 1:00:13 AM
Last Update	: 3/16/2018 1:00:13 AM
Email		: admin@thesilent.com
Homepage	: http://www.thesilent.com
Created by	: TheSilent
Last modified by	: TheSilent
###_______________COPYRIGHT NOTICE_______________###
# Redistributing this software in part or in whole strictly prohibited.
# You may use and modified my software as you wish. 
# If you want to make money from my work please ask first. 
# By using this free software you agree not to blame me for any
# liability that might arise from it's use.
# In all cases this copyright notice and the comments above must remain intact.
# Copyright (c) 2001 TheSilenT.CoM.  All Rights Reserved.
###_______________COPYRIGHT NOTICE_______________###
*/

//if ($_SERVER['SERVER_NAME'] !== 'localhost' AND $_SERVER['REMOTE_ADDR'] !== '62.251.58.180') {exit;}

//_______________-=TheSilenT.CoM=-_________________

//$DEBUG=0;
//$DEBUG=1;

if (isset($DEBUG)) {
error_reporting(E_ALL);
ini_set('display_errors', 1);
}

$tradingfee = 0.25;

//_______________-=TheSilenT.CoM=-_________________

$main = array(
'mysql_host' => 'localhost',
'mysql_user' => 'exchanger',
'mysql_password' => 'PASWORD)@(U(AIOS',

'mysql_main' => 'exchanger',
'mysql_mirror' => 'exchangermirror',
'mysql_backup' => 'exchangerbackup',


'tbl_balances' => 'ex_balances',
'tbl_coins' => 'ex_coins',
'tbl_deposits' => 'ex_deposits',
'tbl_members' => 'ex_members',

'tbl_orders_buy' => 'ex_orders_buy',
'tbl_orders_sell' => 'ex_orders_sell',
'tbl_orders_traded' => 'ex_orders_traded',
'tbl_pairs' => 'ex_pairs',
'tbl_unconfirmed' => 'ex_unconfirmed',
'tbl_withdraws' => 'ex_withdraws',
'tbl_zlogs' => 'ex_zlogs',

'cookie_time' => (86400*30),
'root_url' => 'http://localhost/exchange',

'floats' => 100000000,
'signup_symbol' => 'DOGE',
'signup_confirmations' => '3',
'cancel_withdraws' => '300',
//hardcoded secondpart of the password can be kept on a second server or use get_file
'p2' => 'superlongsecretpasswordwithlotsof*&@!#(&@*#^!@(#(*&87132198230',
'max_deposits' => 100,

);

if ($_SERVER['SERVER_NAME'] == 'localhost') {
$main['mysql_user'] = 'DBUSERS';
$main['mysql_password'] = 'PASWORD)@(U(AIOS';
}

$main['ip'] = addslashes($_SERVER['REMOTE_ADDR']);

$files = array('index','trade','orders','balances','withdraws','deposits','account','ladder','game');
$hash_fields = array('email','password','pin','nemail','npassword','npin');

//_______________-=TheSilenT.CoM=-_________________


if (!isset($link)) {
	$link=mysqli_connect($main['mysql_host'],$main['mysql_user'],$main['mysql_password'],$main['mysql_main']);
	if (!$link) {
		$db_select = mysqli_select_db($link, $main['mysql_mirror']);
		if (!$db_select) {
			mysql_query("REPAIR TABLE `".$main['mysql_main']."`, `orders`, `executed`") or print(mysql_error());
		}
	}else{
	
	}
}


//_______________-=TheSilenT.CoM=-_________________

?>