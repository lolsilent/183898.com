<?php

//_______________-=TheSilenT.CoM=-_________________
//COOKIE
if (isset($_COOKIE['__c'])) {
$cookie_hash=$_COOKIE['__c'];
}elseif (!isset($_COOKIE['__c'])) {
$cookie_hash = cookie_hash($_SERVER);
setcookie('__c',$cookie_hash,time()+$main['cookie_time']);
setcookie('__d',$cookie_hash,time()+$main['cookie_time']);
$_COOKIE['__c']=$cookie_hash;
}else{
$cookie_hash='';
}

//_______________-=TheSilenT.CoM=-_________________
//GET
$_uget = array();
if (!empty($_GET)) {
	foreach ($_GET as $key => $val) {
		$_uget[$key]=alphnum($val);
	}
}

//_______________-=TheSilenT.CoM=-_________________
//POST
$_upost = array();
if (!empty($_POST)) {
	foreach ($_POST as $key => $val) {
		if (in_array($key,$hash_fields)) {
			$_upost[$key] = hash('sha512',$val);
		}else{
			$_upost[$key]=alphnum($val);
		}
	}
}

//_______________-=TheSilenT.CoM=-_________________
//LOGIN

if (!empty($_upost['email']) && !empty($_upost['password']) && !empty($_upost['pin']) && !empty($_upost['login'])) {
$email_hash = $_upost['email'];
$password_hash = $_upost['password'];
$pin_hash = $_upost['pin'];

$query = "SELECT * FROM `".$main['tbl_members']."` WHERE `email` = '$email_hash' AND `password` = '$password_hash' AND `pin` = '$pin_hash' ORDER by `id` DESC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
    if ($row = mysqli_fetch_object($result)) {

$cookie_hash = cookie_hash($_SERVER);
setcookie('__c',$cookie_hash,time()+$main['cookie_time']);
$_COOKIE['__c']=$cookie_hash;



$uquery = "UPDATE `".$main['tbl_members']."` SET `cookie_hash`='$cookie_hash' WHERE `id`='$row->id' LIMIT 1";
if (mysqli_query($link, $uquery)) {
}

//print "$email_hash $password_hash $pin_hash $row->email $row->password $row->pin <hr>$cookie_hash";

$_uget['f'] = 'trade';

		}
}
}

}

//_______________-=TheSilenT.CoM=-_________________

//MEMBER
if (isset($_COOKIE['__c'])) {
$cookie_hash=$_COOKIE['__c'];

$query = "SELECT * FROM `".$main['tbl_members']."` WHERE (`cookie_hash` = '$cookie_hash') ORDER by `id` DESC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
if ($row = mysqli_fetch_object($result)) {
   //print $row->id;
}
}else{

}
}
}

//_______________-=TheSilenT.CoM=-_________________
//LOGOUT

if (!empty($_upost['pin']) && !empty($_upost['logout'])) {
$pin_hash = $_upost['pin'];
if (isset($row->pin) && $row->pin == $pin_hash) {
$cookie_hash = cookie_hash($_SERVER);
setcookie('__c','',time()+$main['cookie_time']);
$_COOKIE['__c']=$cookie_hash;
$_uget['f'] = 'index';
$row->email='';
}
}

//_______________-=TheSilenT.CoM=-_________________

?><!DOCTYPE html>
<html>
<head>
<title>183898.com</title>
<meta http-equiv="cache-control" content="no-cache">

<style>

body { margin:0px; font-family:Arial,Helvetica,sans-serif; font-size:12; color:#ffffff; background-color:#000000;} 
th, .pairs { border:1px #456789 solid; background-color:#333333; padding-left:1px; padding-right:1px; } 
input, select, submit, textarea { margin:2px; border:1px #456789 solid; border-width:1px; font-size:12; background-color:#222222; color:#FFFFFF; text-align:center; } 
a { color:#cccccc; text-decoration:none; } 
a:hover { color:#FFF888; }

#loginform_topright{position: absolute;top: 0px;right: 0px;}

.menuitem{
border:1px #ff0000 solid; background-color:#333333; padding-left:3px; padding-right:3px; 
}
.menuitem:hover{ background-color:#000000; }

.darkgrey {
background-color:#222222;
}

.darkred {
background-color:#EE2233;
}

.darkblue {
background-color:#123456;
}

.yellow {
background-color:#fff126;
}

readonly {
color:#cccccc;
}
</style>
</head>
<body>
<?php
if (empty($row->email) || !isset($row->email)) {
print '<form id="loginform_topright" method=post action="?f=account"><input type="password" name="email" size="20" maxlength="128" value="" placeholder="email"><input type="password" name="password" size="20" maxlength="128" value="" placeholder="password"><input type="password" name="pin" size="20" maxlength="32" value="" placeholder="secret pin"><input type="submit" size="20" name="login" value="login"></form>';
$_uget['f'] = 'index';
}else{
	if (preg_match("/index/sim",$_SERVER['SCRIPT_NAME'])) {


//_______________-=TheSilenT.CoM=-_________________
//MY BALANCES
$my_balances = array();
if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$row->id') ORDER BY `symbol` DESC LIMIT 100") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
	print '<table><tr>';
while ($brow = mysqli_fetch_object ($bresult)) {
	$my_balances[$brow->symbol]=$brow->amount;
	print '<th>'.number_format($brow->amount,2).' '.$brow->symbol.'</th>';
}
mysqli_free_result($bresult);
}
	print '</tr></table>';
}
}

//_______________-=TheSilenT.CoM=-_________________
//MENU BUTTONS
print '<table><tr>';
$filesd = array_shift($files);
foreach ($files as $val) {
	print '<td class="menuitem"><a href="?f='.$val.'">'.strtoupper($val).'</a></td>';
}
print '</tr></table>';
	}
}
?>