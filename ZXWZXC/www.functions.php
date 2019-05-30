<?php

//_______________-=TheSilenT.CoM=-_________________
//INSERT OR UPDATE
function insert_update($link, $table, $whereis, $insert, $update) {
$row= (object)[];
//print '<hr>';
//print "$table, $whereis, $insert, $update";
$query = "SELECT * FROM `$table` WHERE ($whereis) ORDER by `id` DESC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
	if (mysqli_num_rows($result) >= 1) {
		//print '111';
    if ($row = mysqli_fetch_object($result)) {
    	//print '222';
    	mysqli_free_result ($result);
    	$uquery = "UPDATE `$table` SET $update WHERE ($whereis) LIMIT 1";
    	//print $uquery;
			if (mysqli_query($link, $uquery)) {}
    }
	}else{
		//print '333';
		$iquery = "INSERT INTO `$table` VALUES ($insert)";
		if (mysqli_query($link, $iquery)) {}
$query = "SELECT * FROM `$table` WHERE ($whereis) ORDER by `id` DESC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
	if (mysqli_num_rows($result) >= 1) {
		//print '111';
    if ($row = mysqli_fetch_object($result)) {
    	mysqli_free_result ($result);
    }
  }
}
	}
}

print mysqli_error($link);
//print '<hr>';
return ($row);
}
//_______________-=TheSilenT.CoM=-_________________

function wtf($in) {
print '<pre>';
if (is_array($in)) {
print_r($in);
}else{
print ($in);
}
print '</pre>';
}

function fu($in) {
print '<pre>';
foreach ($in as $key=>$val) {
print $key.' '.$val.'
';
}
print '</pre>';
}

//_______________-=TheSilenT.CoM=-_________________

function cookie_hash($in) {
return hash('sha512',preg_replace("/[^A-Za-z0-9]/", '', implode("", $in)));
}

//_______________-=TheSilenT.CoM=-_________________
function alphnum($in) {
return preg_replace("/[^A-Za-z0-9 .@_-]+/", '', $in);
}

//_______________-=TheSilenT.CoM=-_________________

function posint($in) {
$in = preg_replace("/[^0-9.]+/", '', $in);
//$in = (int) $in;
//if (!is_int($in)) {$in=0;}
if ($in < 0) {
$in=0;
}
return $in;
}
//_______________-=TheSilenT.CoM=-_________________

function validate_address($address,$symbol,$link,$main) {
$query = "SELECT * FROM `".$main['tbl_coins']."` WHERE `symbol`='$symbol' ORDER by `id` DESC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
if ($coins = mysqli_fetch_object($result)) {
mysqli_free_result($result);
$crypto = new Bitcoin($coins->rpcuser,$coins->rpcpassword,$coins->rpchost,$coins->rpcport);
return $crypto->validateaddress($address);
}
}
}
}

//_______________-=TheSilenT.CoM=-_________________

function login($main,$in) {

}

//_______________-=TheSilenT.CoM=-_________________
function logout($main,$in) {

}

//_______________-=TheSilenT.CoM=-_________________
function change($main,$in) {

}

//_______________-=TheSilenT.CoM=-_________________

function withdraws($in) {
}

//_______________-=TheSilenT.CoM=-_________________

function send($in) {
}

//_______________-=TheSilenT.CoM=-_________________

function order_buy($in) {
}

//_______________-=TheSilenT.CoM=-_________________

function order_sell($in) {
}

//_______________-=TheSilenT.CoM=-_________________



?>