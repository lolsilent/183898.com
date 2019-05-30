<?php

//_______________-=TheSilenT.CoM=-_________________
//3/28/2018 2:16:14 AM TODO: make sure unregistered account within 30 days will be offered again for signup.

$query = "SELECT * FROM `".$main['tbl_members']."` WHERE `cookie_hash` = '$cookie_hash' ORDER by `id` DESC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
    if ($row = mysqli_fetch_object($result)) {
        $cookie_hash = $row->cookie_hash;

if ($cquery = "SELECT * FROM `".$main['tbl_coins']."` WHERE (`symbol`='".$main['signup_symbol']."') ORDER BY `id` DESC") {
if($cresult = mysqli_query($link, $cquery)) {
if ($coinrow = mysqli_fetch_object ($cresult)) {
	
mysqli_free_result ($cresult);

$amount = ($coinrow->amount+($row->id/$main['floats']));

$crypto = new Bitcoin($coinrow->rpcuser,$coinrow->rpcpassword,$coinrow->rpchost,$coinrow->rpcport);

$alldeposits = $crypto->listtransactions();
if (is_array($alldeposits)) {
$signupdeposits = array();
foreach ($alldeposits as $key => $val) {
	$id = substr($val['amount'],-8);
if (isset($val['confirmations'])) {
	$signupdeposits[$id] = $val['confirmations'];	
}
}

//wtf($signupdeposits);

if (array_key_exists(substr($amount,-8),$signupdeposits)) {
if ($signupdeposits[substr($amount,-8)] >= $main['signup_confirmations']) {
	if (empty($row->email)) {
$deposits_cleared=2; //finish signup

if (!empty($_upost['email']) && !empty($_upost['password']) && !empty($_upost['pin'])) {
$email_hash = $_upost['email'];
$password_hash = $_upost['password'];
$pin_hash = $_upost['pin'];

//print "$email_hash $password_hash $pin_hash";

$uquery = "UPDATE `".$main['tbl_members']."` SET `status`='1', `email`='$email_hash',`password`='$password_hash',`pin`='$pin_hash' WHERE `id`='$row->id' LIMIT 1";

if (mysqli_query($link, $uquery)) {

if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$row->id') ORDER BY `id` DESC") {
if($bresult = mysqli_query($link, $bquery)) {
if ($brow = mysqli_fetch_object ($bresult)) {
mysqli_free_result ($bresult);
}else{
	$bquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$row->id', '0', '$coinrow->symbol', '$amount', '')";
}
}
}


if (mysqli_query($link, $bquery)) {
}

echo '<br><br><br>Welcome.<meta http-equiv="refresh" content="1;url='.$main['root_url'].'?f=trade" />';


}else{

}
}else{
print '<form method=post><input type="password" name="email" size="20" maxlength="128" value="" placeholder="email">
<input type="password" name="password" size="20" maxlength="128" value="" placeholder="password">
<input type="password" name="pin" size="20" maxlength="32" value="" placeholder="secret pin">
<input type="submit" size="20" value="finish signup"></form>';
}


	}	else {
$deposits_cleared=3;//signup completed
echo '<br><br><br>Welcome back.<meta http-equiv="refresh" content="1;url='.$main['root_url'].'?f=trade" />';
	}

}else{
	$deposits_cleared=1; //clearing deposits
	print '<br><br><br>Confirming your deposit '.$signupdeposits[substr($amount,-8)].'/'.$main['signup_confirmations'].'.';
}
}
}//if isarray
}//if coinrow
}
}
    }//if row

}else{

//_______________-=TheSilenT.CoM=-_________________
//REOFFER INACTIVE ACCOUNTS
$inactive_timer = microtime(true)-(86400*30);

//print $inactive_timer.'<hr>';

$rquery = "SELECT * FROM `".$main['tbl_members']."` WHERE (`status` = '0' AND `email`='' AND `password`='' AND `pin`='' AND `timer`<='$inactive_timer') ORDER by `id` ASC LIMIT 1";
if ($rresult = mysqli_query($link, $rquery)) {
if (mysqli_num_rows($rresult) >= 1) {
    if ($rrow = mysqli_fetch_object($rresult)) {
        $cookie_hash = $rrow->cookie_hash;

$cookie_hash = cookie_hash($_SERVER);
setcookie('__c',$cookie_hash,time()+$main['cookie_time']);
setcookie('__d',$cookie_hash,time()+$main['cookie_time']);
$_COOKIE['__c']=$cookie_hash;

$uquery = "UPDATE `".$main['tbl_members']."` SET `cookie_hash`='$cookie_hash',`timer`='".time()."' WHERE `id`='$rrow->id' LIMIT 1";

if (mysqli_query($link, $uquery)) {
}
//print $cookie_hash.'XAXAAXXAXAXAXAXXAXA';

$row = new stdClass();
$row->id=$rrow->id;

mysqli_free_result($rresult);
    }

}else{
//_______________-=TheSilenT.CoM=-_________________
//NO INACTIVE ACCOUNTS FOUND

$query = "INSERT INTO `".$main['tbl_members']."` VALUES (NULL, '0', '".$main['ip']."', '$cookie_hash','','','',".time().")";
mysqli_query($link, $query);

$row = new stdClass();
$row->id=mysqli_insert_id($link);


$query = "SELECT * FROM `".$main['tbl_members']."` WHERE `cookie_hash` = '$cookie_hash' ORDER by `id` DESC LIMIT 10";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
    if ($row = mysqli_fetch_object($result)) {
    }
  }
}
}
}
//_______________-=TheSilenT.CoM=-_________________

}
mysqli_free_result($result);
}

//_______________-=TheSilenT.CoM=-_________________

if (!isset($deposits_cleared)) {
$query = "SELECT * FROM `".$main['tbl_coins']."` WHERE (`symbol`='".$main['signup_symbol']."') ORDER by `id` ASC LIMIT 1";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {

    while ($coins = mysqli_fetch_object($result)) {
    	$amount = ($coins->amount+($row->id/$main['floats']));
print '<br><br>Please deposit EXACTLY '.number_format($amount,8).' '.$coins->symbol.' into '.$coins->address.' to complete signup.';
		}
mysqli_free_result($result);
}
}

}


//_______________-=TheSilenT.CoM=-_________________
print '<br><br>Coins you can exchange here are : ';

$query = "SELECT * FROM `".$main['tbl_coins']."` WHERE `id` ORDER BY `id` ASC LIMIT 1000";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {

    while ($coins = mysqli_fetch_object($result)) {
    	print $coins->symbol.' ';
		}
mysqli_free_result($result);
}
}
print '<br>Any coin can be added or removed with or without notice in this beta fase.<br><br>';
?>
<hr>My plan for this exchange:<br>
For small traders and peoples.<br>
By law its not allowed in my country to exchange to fiat money.<br>
<br>
DEPOSITS:<br>
Deposits will done with blockchain explorer.<br>
All deposit go to a single address.<br>
The number behind the dot is your deposit id for this account. 0.00000001<br>
<br>
WITHDRAWS:<br>
Max withdraws 1 per ip per account per 24 hours.<br>
Withdraws above 1000 usd/euro needs manual approval.<br>
<br>
ORDERS:<br>
To prevent trash in the orderbook fee is taken when order is placed and not returned when cancelled.<br>
<br>
This is just an study project when all done maybe ill put it on github.<br>
