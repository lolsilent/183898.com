<?php
try {
$atime_start = microtime(true);

if ($_SERVER['SERVER_NAME'] !== 'localhost' AND $_SERVER['REMOTE_ADDR'] !== '62.251.58.180' AND $row->id !== 1) {exit;}
//_______________-=TheSilenT.CoM=-_________________

require_once('ZXWZXC/www.main.php');
require_once('ZXWZXC/www.functions.php');
require_once('ZXWZXC/www.json.php');
include_once('ZXWZXC/www.header.php');


//_______________-=TheSilenT.CoM=-_________________
//CANCEL WITHDRAWS
if (isset($_upost['id'])) {if (isset($_upost['cid'])) {
$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE (`txid` = '' AND `id`='".$_upost['cid']."') ORDER by `id` ASC LIMIT 5";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
while ($wrow = mysqli_fetch_object($iresult)) {
	if (isset($_upost[$wrow->symbol])) {
		if ($_upost[$wrow->symbol] == 'cancel') {
	if ($_upost['id'] == $wrow->id){
	if ($_upost['cid'] == $wrow->id){
		$wquery = "DELETE FROM `".$main['tbl_withdraws']."` WHERE `id`='$wrow->id' LIMIT 1";
		$bquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+'$wrow->amount' WHERE (`member_id`='$wrow->member_id' AND `symbol`='$wrow->symbol') LIMIT 1";
		if (mysqli_query($link, $wquery)) {
		//print 'wquery excute ';
		}
		if (mysqli_query($link, $bquery)) {
		//print 'bquery excute ';
		}
	}
	}
		}
	}
}
mysqli_free_result($iresult);
}}
}}
//_______________-=TheSilenT.CoM=-_________________
//SEND WITHDRAWS

if (isset($_upost['id'])) {if (isset($_upost['sid'])) {

exec("tasklist 2>NUL", $task_list);

foreach ($task_list as $key => $val) {
	$task_list[$key] = preg_replace("/  .*?$/sim","",$val);
}

$task_list = array_unique($task_list);
//wtf($task_list);


$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE (`txid` = '' AND `id`='".$_upost['sid']."') ORDER by `id` ASC LIMIT 5";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
while ($wrow = mysqli_fetch_object($iresult)) {
	if (isset($_upost[$wrow->symbol])) {
		if ($_upost[$wrow->symbol] == 'send') {
	if ($_upost['id'] == $wrow->id){
	if ($_upost['sid'] == $wrow->id){


//_______________-=TheSilenT.CoM=-_________________


$jquery = "SELECT * FROM `".$main['tbl_coins']."` WHERE `symbol`='$wrow->symbol' ORDER by `id` ASC LIMIT 1";
if ($jresult = mysqli_query($link, $jquery)) {
if (mysqli_num_rows($jresult) >= 1) {
if ($coins = mysqli_fetch_object($jresult)) {
mysqli_free_result($jresult);
if (!empty($coins->address)) {

if (in_array($coins->process, $task_list)) {

$time_start = microtime(true);

$crypto = new Bitcoin($coins->rpcuser,$coins->rpcpassword,$coins->rpchost,$coins->rpcport);

$wrow->amount = $wrow->amount - $coins->fee;
$wrow->amount = (int) $wrow->amount;

$p1=$coins->p1.$main['p2'];
if (isset($_upost['p1']) AND !empty($_upost['p1'])) {
	$p1=$_upost['p1'];
}
$crypto->walletpassphrase($p1,1);
$txid=$crypto->sendtoaddress($wrow->address, $wrow->amount);
$crypto->walletlock();


//echo $txid ? $txid : "Oops an error: ".$crypto->error;

	if (isset($txid) AND !empty($txid)) {
		$bquery = "UPDATE `".$main['tbl_withdraws']."` SET `txid`='$txid' WHERE `id`='$wrow->id' LIMIT 1";
		if (mysqli_query($link, $bquery)) {
		print 'SEND excute '.$wrow->address.' '.$wrow->amount;
		}
	}else{
		print 'FUCK ERROR!!';
	}
}
}
}
}
}

//_______________-=TheSilenT.CoM=-_________________

	}
	}
		}
	}
}
mysqli_free_result($iresult);
}}
}}
//_______________-=TheSilenT.CoM=-_________________
//WITHDRAWS UNSENT



$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE `txid` = '' ORDER by `id` ASC LIMIT 50";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

print '<table><tr><th colspan=6>withdraw requests</th></tr>';
print '<tr><th></th><th>mid</th><th></th><th>confirmations</th><th>amount</th><th>address</th><th>txid</th></tr>';

while ($wrow = mysqli_fetch_object($iresult)) {

if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<form method=post>';

if (isset($_upost['id'])) {
	if ($_upost['id'] == $wrow->id){
		if (isset($_upost[$wrow->symbol])) {
			if ($_upost[$wrow->symbol] == 'cancel') {
		print '<input type="hidden" name="cid" value="'.$wrow->id.'">';
		$bg=' class="darkred"';
			}else{
		print '<input type="hidden" name="sid" value="'.$wrow->id.'">';
		$bg=' class="darkblue"';	
			}
		}
	}
}


print '<tr'.$bg.'><td><input type="submit" value="cancel" name="'.$wrow->symbol.'"></td><td>'.$wrow->member_id.'</td><td>'.$wrow->symbol.'</td><td align=right>'.$wrow->confirmations.'</td><td align=right>'.number_format($wrow->amount,8).'</td><td>'.$wrow->address.'</td><td>'.$wrow->txid.'</td><td>'.(empty($wrow->txid)?'<input type="submit" value="send" name="'.$wrow->symbol.'"><input type="password" name="p1" value=""><input type="hidden" name="id" value="'.$wrow->id.'">':'').'</td>';

print '</tr></form>';

}
mysqli_free_result($iresult);


print '</table>';


}
}



//_______________-=TheSilenT.CoM=-_________________
//WITHDRAWS ALREADY SEND
$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE `txid` != '' ORDER by `id` ASC LIMIT 50";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

print '<table><tr><th colspan=6>withdraw requests SEND</th></tr>';
print '<tr><th></th><th>confirmations</th><th>amount</th><th>address</th><th>txid</th></tr>';

while ($wrow = mysqli_fetch_object($iresult)) {

if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<form method=post><tr'.$bg.'><td>'.$wrow->symbol.'</td><td align=right>'.$wrow->confirmations.'</td><td align=right>'.number_format($wrow->amount,8).'</td><td>'.$wrow->address.'</td><td>'.$wrow->txid.'</td><td>'.(empty($wrow->txid)?'<input type="submit" value="cancel" name="'.$wrow->symbol.'"><input type="hidden" name="id" value="'.$wrow->id.'">':'').'</td></tr></form>';

}
mysqli_free_result($iresult);


print '</table>';


}
}




//_______________-=TheSilenT.CoM=-_________________
//aal balances
if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE `id` ORDER BY `member_id` DESC LIMIT 100") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {

while ($brow = mysqli_fetch_object ($bresult)) {
	print '<br>'.$brow->member_id.' '.number_format($brow->amount,5).' '.$brow->symbol;
}
mysqli_free_result($bresult);
}

}
}

//_______________-=TheSilenT.CoM=-_________________

print '<br> C'.number_format(microtime(true) - $atime_start, 3);

include_once('ZXWZXC/www.footer.php');

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>
