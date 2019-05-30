<?php

//_______________-=TheSilenT.CoM=-_________________
//DEFINE
$min=1;
$max=100;
$imax=$max*10;
if (isset($_upost['max']) and !empty($_upost['max'])) {
$max = posint($_upost['max']);
if ($max > $imax) {
	$max=$imax;
}
}
$betamount=1;
$ibetamount=$betamount*1000;
if (isset($_upost['betamount']) and !empty($_upost['betamount'])) {
$betamount = posint($_upost['betamount']);
if ($betamount > $ibetamount) {
	$betamount=$ibetamount;
}
}
$winamount=(($max*$betamount)/1);
$dice = rand($min,$max);
$tbl_gamble = 'ex_gamble';

//_______________-=TheSilenT.CoM=-_________________
//CHECK BALANCES
//print array_sum($my_balances);

if (array_sum($my_balances) >= 1) {

print '<table><tr>';
foreach($my_balances as $key=>$val) {
	if ($val >= 1) {
		print '<th><a href="?f=game&b='.$key.'">'.$key.'</a></th>';
	}
}
print '</th></table>';

if (isset($_uget['b']) and !empty($_uget['b']) and array_key_exists($_uget['b'],$my_balances)) {
//CHECK GET INARRAYKEY
$currency = $_uget['b'];
//_______________-=TheSilenT.CoM=-_________________




print 'Try your luck here. Bet '.$betamount.' and win '.number_format($winamount).'. ';

if (isset($_upost['action']) and !empty($_upost['action'])) {
$action=($_upost['action']);
}

if (isset($_uget['action']) and !empty($_uget['action'])) {
$action=($_uget['action']);
}


if (!empty($action)) {
	if ($action >= $min && $action <= $max) {
	} elseif($action == 'r') {
		$action = rand($min,$max);
	}else{
		$action = 1;
	}
}else{$action = '';}

if (!empty($action)) {
	if ($action >= $min && $action <= $max) {
	} elseif($action == 'r') {
		$action = rand($min,$max);
	}else{
		$action = 1;
	}
}else{$action = '';}
	
if (!empty($action)) {
	if ($action >= $min && $action <= $max) {
	} elseif($action == 'r') {
		$action = rand($min,$max);
	}else{
		$action = 1;
	}
}else{$action = '';}


$table = "$tbl_gamble";
$whereis = "`member_id`='$row->id' AND `symbol`='$currency'";
$insert = "NULL, '$row->id', '$currency', 0, 0";
$update = "`games`=`games`+1";
$grow = insert_update($link, $table, $whereis, $insert, $update);

//_______________-=TheSilenT.CoM=-_________________
//PAYED PRICES



//_______________-=TheSilenT.CoM=-_________________
//ROLL WIN LOSE PRICE
if ($action == $dice || $grow->winlose >= 100) {
$dice = rand($min,$max);
}

/*
$aaa=0;$bbb=0;
for ($i=0;$i<=1000000;$i++) {
$dice = rand($min,$max);
//print $action.' '.$dice.'|';
if ($action == $dice) {
$dice = rand($min,$max);
$bbb++;
}
if ($action == $dice) {
	$aaa++;
}
}
print '---B'.number_format(1000000*$betamount).'RRR'.$bbb.'+++W'.$aaa.'___W'.number_format($aaa*$winamount);
*/
//_______________-=TheSilenT.CoM=-_________________
//ROLLING GAME
print 'You rolled '.$dice.' out of '.$min.' or '.$max.'. ';

if ($query = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$row->id'and `symbol`='$currency') ORDER BY `id` DESC") {
if ($result = mysqli_query($link, $query)) {
if ($brow = mysqli_fetch_object ($result)) {
mysqli_free_result ($result);

if (!empty($action) and $brow->amount > 0 AND $brow->amount >= $betamount) {

if ($action == $dice) {
	print 'You win! '.$action .' vs '.$dice;
	$winner = ($winamount-$betamount);
	$brow->amount+$winamount;

mysqli_query($link, "UPDATE `$tbl_gamble` SET `games`=`games`+1, `winlose`=`winlose`+$winner WHERE (`member_id`='$row->id' AND `symbol`='$currency') LIMIT 1");

mysqli_query($link, "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+$winner WHERE (`member_id`='$row->id' AND `symbol`='$currency') LIMIT 1");

}else{
	print 'You lost! '.$action .' vs '.$dice;
	$brow->amount=$brow->amount-$betamount;
	$grow->winlose=$grow->winlose-$betamount;
mysqli_query($link, "UPDATE `$tbl_gamble` SET `games`=`games`+1, `winlose`=`winlose`-'$betamount' WHERE (`member_id`='$row->id' AND `symbol`='$currency') LIMIT 1");
mysqli_query($link, "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`-'$betamount' WHERE (`member_id`='$row->id' AND `symbol`='$currency') LIMIT 1");
}
}

}}}

//_______________-=TheSilenT.CoM=-_________________
//PRINT GAME BUTTONS
$braky= round(sqrt($max));

print '<form method=post data-transition="fade"><table>
<tr><th colspan='.$braky.'>You have '.number_format($brow->amount).' '.$currency.'<br> Your win lose is '.number_format($grow->winlose).' out of '.number_format($grow->games).' games</th></tr>';
print '<tr><th colspan='.$braky.'>BET <input type=text name="betamount" value="'.$betamount.'">/'.$ibetamount.' WIN <input type=text name="max" value="'.$max.'">/'.$imax.'</th></tr>';
$j=0;
for ($i=$min;$i<=$max;$i++) {
if ($j == 0) {print '<tr>';}

print '<td><input type=submit name=action value="'.$i.'" style="width:100%;height:100%;"></td>';
$j++;
if ($j == $braky) {print '</tr>';$j=0;}
}

print '</table></form>';




}//array_key_exists
}else{
	print 'Not enough balance.';
}



//_______________-=TheSilenT.CoM=-_________________
//PRINT PLAYER SCORES
/*
if ($query = "SELECT * FROM `$tbl_gamble` WHERE `id` ORDER BY `id` DESC LIMIT 50") {
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
print '<table><tr><td>';
while ($grow = mysqli_fetch_object ($result)) {
print number_format($grow->winlose,3).' '.$grow->symbol.' ';
}
mysqli_free_result ($result);
print '</td></tr></table>';
}
}
}
*/
//_______________-=TheSilenT.CoM=-_________________
print '<meta http-equiv="refresh" content="3;URL=?f=game&b=SLOTH&action=r" />';

?>