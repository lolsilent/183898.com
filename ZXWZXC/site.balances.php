<?php

//_______________-=TheSilenT.CoM=-_________________

exec("tasklist 2>NUL", $task_list);

foreach ($task_list as $key => $val) {
	$task_list[$key] = preg_replace("/  .*?$/sim","",$val);
}

$task_list = array_unique($task_list);
//wtf($task_list);

//_______________-=TheSilenT.CoM=-_________________
//CANCEL WITHDRAWS

if (isset($_upost['id']) && !empty($_upost['id'])) {
$wid = $_upost['id'];
$cancel_timer = time()-$main['cancel_withdraws'];
$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE (`id`='$wid' AND `member_id`='$row->id' AND `timer` >= '$cancel_timer') ORDER by `id` ASC LIMIT 1";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
if ($wrow = mysqli_fetch_object($iresult)) {
mysqli_free_result ($iresult);
if (empty($wrow->txid)) {
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+'$wrow->amount' WHERE (`member_id`='$row->id' AND `symbol`='$wrow->symbol') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
$dquery = "DELETE FROM `".$main['tbl_withdraws']."` WHERE `id`='$wrow->id' LIMIT 1";
if (mysqli_query($link, $dquery)) {}
unset($_upost['id']);
}
}}}}


//_______________-=TheSilenT.CoM=-_________________

//REQUEST WITHDRAW
if (!empty($_upost['address']) && !empty($_upost['amount']) && !empty($_upost['pin']) && !empty($_upost['symbol'])) {
$pin_hash = $_upost['pin'];

$symbol = alphnum($_upost['symbol']);
$address = alphnum($_upost['address']);
$amount = posint($_upost['amount']);

//print "$address $row->pin == $pin_hash and $amount > 0";
if ($row->pin == $pin_hash and $amount > 0) {


if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`symbol`='$symbol' AND `member_id`='$row->id') ORDER BY `symbol` DESC LIMIT 10") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
while ($brow = mysqli_fetch_object ($bresult)) {
	 $validate_address = validate_address($address,$symbol,$link,$main);
	 //wtf($validate_address);
if ($validate_address['isvalid'] == 1) {


//_______________-=TheSilenT.CoM=-_________________

$cquery = "SELECT * FROM `".$main['tbl_coins']."` WHERE `symbol`='$brow->symbol' ORDER by `id` DESC LIMIT 1";
if ($cresult = mysqli_query($link, $cquery)) {
if (mysqli_num_rows($result) >= 1) {
if ($coins = mysqli_fetch_object($cresult)) {
mysqli_free_result ($cresult);
$amount += $coins->fee;
}
}
}

//_______________-=TheSilenT.CoM=-_________________
if ($address !== $brow->address) {
$uquery = "UPDATE `".$main['tbl_balances']."` SET `address`='$address' WHERE `id`='$brow->id' LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}
if ($amount <= $brow->amount AND $amount >= $coins->amount) {
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`-'$amount' WHERE `id`='$brow->id' LIMIT 1";
if (mysqli_query($link, $uquery)) {}


//_______________-=TheSilenT.CoM=-_________________
$dquery = "INSERT INTO `".$main['tbl_withdraws']."` VALUES (NULL, '$row->id', '$brow->symbol', '0', '$amount', '$address', '',".time().")";
if (mysqli_query($link, $dquery)) {}
//_______________-=TheSilenT.CoM=-_________________

}
}else{ print 'Rebooting wallet or incorrect address!';}
}
mysqli_free_result ($bresult);
}
}
}


//print 'Withdraw request has been send.';
}
}


//_______________-=TheSilenT.CoM=-_________________



//_______________-=TheSilenT.CoM=-_________________

//BALANCE
$query = "SELECT * FROM `".$main['tbl_coins']."` WHERE `id` ORDER by `symbol` ASC LIMIT ".$main['max_deposits'];
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
print '<form method=post><table><tr><th colspan=8><div class="darkred">The number behind the dot is your deposit id for this account. '.number_format(($row->id/$main['floats']),8).'.<br>If you want to deposit 100 coins you must send as '.number_format(100+($row->id/$main['floats']),8).' or you LOSE YOUR CRYPTOS!<br>Excluding any fees and dont send less than 1 crypto or its GONE FOREVER.</div></th></tr>';
print '<tr><th></th><th>balance</th><th>deposit address</th><th>minimum transfer</th><th>withdraw fee</th><th>confirmations</th><th>status</th></tr>';
    while ($coins = mysqli_fetch_object($result)) {
    	$nowamount=0;
    	$nowaddress='';
if (!empty($coins->address)) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<tr'.$bg.'><td>'.$coins->symbol.'</td>';
if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`symbol`='$coins->symbol' AND `member_id`='$row->id') ORDER BY `symbol` DESC LIMIT ".$main['max_deposits']) {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
while ($brow = mysqli_fetch_object ($bresult)) {
print '<td align=right>'.number_format($brow->amount,8).'</td>';
$nowamount=$brow->amount;
$nowaddress=$brow->address;
}
mysqli_free_result ($bresult);
}else{
print '<td align=right>'.number_format(0,8).'</td>';
}
}
}
print '<td align=right>'.$coins->address.'</td>';
print '<td align=right>'.number_format($coins->amount+($row->id/$main['floats']),8).'</td>';
print '<td align=right>'.$coins->fee.'</td>';
print '<td align=right>'.$coins->confirmations.'</td>';
if (!in_array($coins->process, $task_list)) {
	print '<td align=right>maintenance</td>';
}else{

if ($nowamount > 0) {
print '<td align=right><input type="submit" value="withdraw" name="'.$coins->symbol.'"></td>';
}else{
	print '<td></td>';
}

}

print '</tr>';

if (isset($_upost[$coins->symbol])) {
print '<tr><td colspan="6">
<input type="text" name="address" size=50 placeholder="withdraw '.$coins->symbol.' address" value="'.$nowaddress.'">
<input type="text" name="amount" placeholder="amount '.$coins->symbol.' to withdraw" value="'.(isset($_upost['amount'])?$_upost['amount']:'').'">
<input type="password" name="pin" size="20" maxlength="32" value="'.(isset($_POST['pin'])?$_POST['pin']:'').'" placeholder="secret pin">
<input type="hidden" name="symbol" value="'.$coins->symbol.'">
<input type="submit" value="withdraw" name="'.$coins->symbol.'"></td></tr>';
}

}//empty address



		}
mysqli_free_result($result);
print '</table></form>';
}
}

//_______________-=TheSilenT.CoM=-_________________
//WITHDRAWS

$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT ".($main['max_deposits']/10);
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

print '<table><tr><th colspan=6>last '.($main['max_deposits']/10).' withdraw requests<br>can be cancelled with '.number_format($main['cancel_withdraws']/60).' minutes<br>will be processed within '.number_format($main['cancel_withdraws']*3/60).' minutes</th></tr>';
print '<tr><th></th><th>confirmations</th><th>amount</th><th>address</th><th>txid</th></tr>';

$cancel_timer = time()-$main['cancel_withdraws'];

while ($wrow = mysqli_fetch_object($iresult)) {


if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<form method=post><tr'.$bg.'><td>'.$wrow->symbol.'</td><td align=right>'.number_format($wrow->confirmations).'</td><td align=right>'.number_format($wrow->amount,8).'</td><td>'.$wrow->address.'</td><td>'.$wrow->txid.'</td>'.
($wrow->timer > $cancel_timer?'<td>'.
(empty($wrow->txid)?'<input type="submit" value="cancel" name="'.$wrow->symbol.'"><input type="hidden" name="id" value="'.$wrow->id.'">':'').'</td>':'')

.'</tr></form>';

}
mysqli_free_result($iresult);


print '</table>';


}
}
//_______________-=TheSilenT.CoM=-_________________
//UNCONFIRMED DEPOSITS

$iquery = "SELECT * FROM `".$main['tbl_unconfirmed']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT ".($main['max_deposits']/10);
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

print '<table><tr><th colspan=5>last '.($main['max_deposits']/10).' unverified deposits</th></tr>';
print '<tr><th></th><th>confirmations</th><th>amount</th><th>txid</th></tr>';

while ($uncon = mysqli_fetch_object($iresult)) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<tr'.$bg.'><td>'.$uncon->symbol.'</td><td align=right>'.$uncon->confirmations.'</td><td align=right>'.number_format($uncon->amount,8).'</td><td>'.$uncon->txid.'</td></tr>';
}
mysqli_free_result($iresult);


print '</table>';


}
}

//_______________-=TheSilenT.CoM=-_________________
//CONFIRMED

$iquery = "SELECT * FROM `".$main['tbl_deposits']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT ".($main['max_deposits']/10);
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
	

print '<table><tr><th colspan=5>last '.($main['max_deposits']/10).' verified deposits</th></tr>';
print '<tr><th></th><th>confirmations</th><th>amount</th><th>txid</th></tr>';

while ($drow = mysqli_fetch_object($iresult)) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<tr'.$bg.'><td>'.$drow->symbol.'</td><td align=right>'.number_format($drow->confirmations).'</td><td align=right>'.number_format($drow->amount,8).'</td><td>'.$drow->txid.'</td></tr>';
}
mysqli_free_result($iresult);


print '</table>';


}
}

//_______________-=TheSilenT.CoM=-_________________

?>

