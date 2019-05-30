<?php
try {
$atime_start = microtime(true);

if ($_SERVER['SERVER_NAME'] !== 'localhost' AND $_SERVER['REMOTE_ADDR'] !== '62.251.58.180') {exit;}
//_______________-=TheSilenT.CoM=-_________________

require_once('ZXWZXC/www.main.php');
require_once('ZXWZXC/www.functions.php');
require_once('ZXWZXC/www.json.php');
include_once('ZXWZXC/www.header.php');

print time().'<hr>';


//_______________-=TheSilenT.CoM=-_________________

exec("tasklist 2>NUL", $task_list);

foreach ($task_list as $key => $val) {
	$task_list[$key] = preg_replace("/  .*?$/sim","",$val);
}

$task_list = array_unique($task_list);
//wtf($task_list);

//_______________-=TheSilenT.CoM=-_________________

$query = "SELECT * FROM `".$main['tbl_coins']."` WHERE `id` ORDER by `id` ASC LIMIT 1000";
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
while ($coins = mysqli_fetch_object($result)) {

//_______________-=TheSilenT.CoM=-_________________
//SEND WITHDRAWS
$cancel_timer = time()-($main['cancel_withdraws']+60);
$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE (`txid` = '' AND `symbol`='$coins->symbol' AND `timer` < '$cancel_timer') ORDER by `id` ASC LIMIT 100000";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
while ($wrow = mysqli_fetch_object($iresult)) {

//_______________-=TheSilenT.CoM=-_________________

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




	if (isset($txid) AND !empty($txid)) {
		$bquery = "UPDATE `".$main['tbl_withdraws']."` SET `txid`='$txid' WHERE `id`='$wrow->id' LIMIT 1";
		if (mysqli_query($link, $bquery)) {
		print 'SEND excute '.$wrow->address.' '.$wrow->amount;
		}
	}else{
		print 'FUCK ERROR!!';
		echo $txid ? $txid : "Oops an error: ".$crypto->error;
	}
}

//_______________-=TheSilenT.CoM=-_________________
}
mysqli_free_result($iresult);
}}

//SEND WITHDRAWS
//_______________-=TheSilenT.CoM=-_________________

if (!empty($coins->address)) {
	print 'deposit allowed on '.$coins->symbol;
if (in_array($coins->process, $task_list)) {
	print ' process is active';
$time_start = microtime(true);
print ' A'.number_format(microtime(true) - $time_start, 3);
$crypto = new Bitcoin($coins->rpcuser,$coins->rpcpassword,$coins->rpchost,$coins->rpcport);
print ' B'.number_format(microtime(true) - $time_start, 3);
wtf($crypto->getblockchaininfo());
$alldeposits = $crypto->listtransactions();
print ' C'.number_format(microtime(true) - $time_start, 3);
print ' '.$coins->symbol;
//wtf($alldeposits);

//print '<hr>';
if (!empty($alldeposits)) {
	//print ' ONLINE ';

//_______________-=TheSilenT.CoM=-_________________
//IGNORE SELF AND TEST TRANSFERS
	$ignoretxid = array();
foreach ($alldeposits as $key => $val) {
	if (preg_match("/send/",$alldeposits[$key]['category']) AND $alldeposits[$key]['address'] == $coins->address) {
		$ignoretxid[] = $alldeposits[$key]['txid'];
		//print $alldeposits[$key]['txid'];
	}
}

//_______________-=TheSilenT.CoM=-_________________
//ALL RECEIVE

foreach ($alldeposits as $key => $val) {
	if (preg_match("/receive/",$alldeposits[$key]['category']) AND $alldeposits[$key]['address'] == $coins->address AND !in_array($alldeposits[$key]['txid'], $ignoretxid)) {
		//print 'CAT '.$alldeposits[$key]['category'].'<br>';
		$amount = $alldeposits[$key]['amount'];
		$confirmations = $alldeposits[$key]['confirmations'];
			$txid = $alldeposits[$key]['txid'];
			$member_id = str_pad(preg_replace("/^.*?\./","",$amount),8,'0');
			//print 'MID '.$member_id.' ';
			$member_id = ltrim($member_id,'0');
			//print 'MID '.$member_id.' ';
			
		if ($confirmations > $coins->confirmations) {

			$uquery = "DELETE FROM `".$main['tbl_unconfirmed']."` WHERE `txid`='$txid' LIMIT 1";
			if (mysqli_query($link, $uquery)) {
			//print 'delete unconfirmed ';
			}
			
		if ($amount > 0) {


$iquery = "SELECT * FROM `".$main['tbl_deposits']."` WHERE `txid`='$txid' ORDER by `id` ASC LIMIT 1";
if ($iresult = mysqli_query($link, $iquery)) {
	if (mysqli_num_rows($iresult) >= 1) {
		//print 'update deposit ';
		$dquery = "UPDATE `".$main['tbl_deposits']."` SET `confirmations`='$confirmations' WHERE `txid`='$txid'";
		if (mysqli_query($link, $dquery)) {
		}
	}else{
			$dquery = "INSERT INTO `".$main['tbl_deposits']."` VALUES (NULL, '$member_id', '$coins->symbol', '$confirmations', '$amount', '$txid')";
			if (mysqli_query($link, $dquery)) {
			print 'insert deposit ';

$iquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$member_id' AND `symbol`='$coins->symbol') ORDER by `id` ASC LIMIT 1";
if ($iresult = mysqli_query($link, $iquery)) {
	if (mysqli_num_rows($iresult) >= 1) {
		if ($brow = mysqli_fetch_object($iresult)) {
			print 'update balance ';
			$bquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+$amount WHERE `id`='$brow->id'";
		}
	}else{
		print 'insert balance ';
		$bquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$member_id', '0', '$coins->symbol', '$amount', '')";

	}
		if (mysqli_query($link, $bquery)) {
		print 'query excute ';
		}
}


			}
	}
}else{
}
		}//amount > 0

		}else{
			$uquery = "INSERT INTO `".$main['tbl_unconfirmed']."` VALUES (NULL, '$member_id', '$coins->symbol', '$confirmations', '$amount', '$txid')";
			if (mysqli_query($link, $uquery)) {
			print 'insert unconfirmed ';
			}else{
				$uquery = "UPDATE `".$main['tbl_unconfirmed']."` SET `confirmations`='$confirmations' WHERE `txid`='$txid'";
				if (mysqli_query($link, $uquery)) {
				print 'update unconfirmed ';
				}
			}
		}//confirmations > met
	}
}

//_______________-=TheSilenT.CoM=-_________________
//ALL SEND

foreach ($alldeposits as $key => $val) {
	if (preg_match("/send/",$alldeposits[$key]['category']) AND !in_array($alldeposits[$key]['txid'], $ignoretxid)) {
		//print 'CAT '.$alldeposits[$key]['category'].'<br>';
		$amount = $alldeposits[$key]['amount'];
		$confirmations = $alldeposits[$key]['confirmations'];
		$txid = $alldeposits[$key]['txid'];
				$uquery = "UPDATE `".$main['tbl_withdraws']."` SET `confirmations`='$confirmations' WHERE `txid`='$txid'";
				if (mysqli_query($link, $uquery)) {
				//print 'update confirmations ';
				}
		}
	}
//_______________-=TheSilenT.CoM=-_________________

}//isrray and set

print '<br>D'.number_format(microtime(true) - $time_start, 3);

}else{print ' PROCESS not running';}//coin process runingn

print '<hr>';
}else{print '';}//coin deposit address


}
mysqli_free_result($result);

}
}

//print '<meta http-equiv="refresh" content="10;URL=?update" />';

include_once('ZXWZXC/www.footer.php');

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
