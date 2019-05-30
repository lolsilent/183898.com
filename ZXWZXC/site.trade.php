<?php
/*
//_______________-=TheSilenT.CoM=-_________________
//EXECUTE
$jquery = "SELECT * FROM `".$main['tbl_orders_buy']."` WHERE `id` ORDER by `price` ASC LIMIT 1000";
if ($jresult = mysqli_query($link, $jquery)) {
if (mysqli_num_rows($jresult) >= 1) {
while ($brow = mysqli_fetch_object($jresult)) {


$iquery = "SELECT * FROM `".$main['tbl_orders_sell']."` WHERE (`price`='$brow->price' AND `symbol`='$brow->symbol' AND `symbolb`='$brow->symbolb') ORDER by `price` ASC LIMIT 1000";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
while ($srow = mysqli_fetch_object($iresult)) {


//print "$brow->price $srow->price $brow->amount $srow->amount";
if ($brow->amount > 0 && $brow->amount == $srow->amount) {

//_______________-=TheSilenT.CoM=-_________________

//print '===';
//fu($brow);fu($srow);


$bquery = "DELETE FROM `".$main['tbl_orders_buy']."` WHERE `id`='$brow->id' LIMIT 1";if (mysqli_query($link, $bquery)) {}
$squery = "DELETE FROM `".$main['tbl_orders_sell']."` WHERE `id`='$srow->id' LIMIT 1";if (mysqli_query($link, $squery)) {}
$tquery = "INSERT INTO `".$main['tbl_orders_traded']."` VALUES (NULL, '$brow->member_id', '$srow->member_id', '$brow->symbol', '$brow->symbolb', '$brow->amount', '$brow->price', '3', ".time().")";if (mysqli_query($link, $tquery)) {}


if ($tbquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$brow->member_id' AND `symbol`='$brow->symbolb') ORDER BY `member_id` DESC LIMIT 1") {
if($tbresult = mysqli_query($link, $tbquery)) {
if (mysqli_num_rows($tbresult) >= 1) {//print 'aaa';
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+$brow->amount WHERE (`member_id`='$brow->member_id' AND `symbol`='$brow->symbolb') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}else{//print 'bbb';
$tbuquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$brow->member_id', '0', '$brow->symbolb', '$brow->amount', '')";
if (mysqli_query($link, $tbuquery)) {}
}
}
}

if ($tsquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$srow->member_id' AND `symbol`='$brow->symbol') ORDER BY `member_id` DESC LIMIT 1") {
if($tsresult = mysqli_query($link, $tsquery)) {
if (mysqli_num_rows($tsresult) >= 1) {//print 'ccc';
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+($brow->amount*$brow->price) WHERE (`member_id`='$srow->member_id' AND `symbol`='$brow->symbol') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}else{//print 'ddd';
$tbuquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$srow->member_id', '0', '$brow->symbol', '".($brow->amount*$brow->price)."', '')";
if (mysqli_query($link, $tbuquery)) {}
}
}
}



$brow->amount=0;
$srow->amount=0;
}elseif ($brow->amount > 0 && $brow->amount > $srow->amount) {

//_______________-=TheSilenT.CoM=-_________________

//print '>>>';

$bquery = "UPDATE `".$main['tbl_orders_buy']."` SET `amount`=`amount`-'$srow->amount' WHERE `id`='$brow->id' LIMIT 1";if (mysqli_query($link, $bquery)) {}
$squery = "DELETE FROM `".$main['tbl_orders_sell']."` WHERE `id`='$srow->id' LIMIT 1";if (mysqli_query($link, $squery)) {}
$tquery = "INSERT INTO `".$main['tbl_orders_traded']."` VALUES (NULL, '$brow->member_id', '$srow->member_id', '$srow->symbol', '$srow->symbolb', '$srow->amount', '$srow->price', '1', ".time().")";if (mysqli_query($link, $tquery)) {}


if ($tbquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$brow->member_id' AND `symbol`='$brow->symbolb') ORDER BY `member_id` DESC LIMIT 1") {
if($tbresult = mysqli_query($link, $tbquery)) {
if (mysqli_num_rows($tbresult) >= 1) {//print 'aaa';
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+$srow->amount WHERE (`member_id`='$brow->member_id' AND `symbol`='$brow->symbolb') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}else{//print 'bbb';
$tbuquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$brow->member_id', '0', '$brow->symbolb', '$srow->amount', '')";
if (mysqli_query($link, $tbuquery)) {}
}
}
}

if ($tsquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$srow->member_id' AND `symbol`='$brow->symbol') ORDER BY `member_id` DESC LIMIT 1") {
if($tsresult = mysqli_query($link, $tsquery)) {
if (mysqli_num_rows($tsresult) >= 1) {//print 'ccc';
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+($srow->amount*$srow->price) WHERE (`member_id`='$srow->member_id' AND `symbol`='$brow->symbol') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}else{//print 'ddd';
$tbuquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$srow->member_id', '0', '$brow->symbol', '".($srow->amount*$srow->price)."', '')";
if (mysqli_query($link, $tbuquery)) {}
}
}
}

$brow->amount-=$srow->amount;
$srow->amount=0;
}elseif ($brow->amount > 0 && $brow->amount < $srow->amount) {

//_______________-=TheSilenT.CoM=-_________________

//print '<<<';

$bquery = "DELETE FROM `".$main['tbl_orders_buy']."` WHERE `id`='$brow->id' LIMIT 1";if (mysqli_query($link, $bquery)) {}
$bquery = "UPDATE `".$main['tbl_orders_sell']."` SET `amount`=`amount`-'$brow->amount' WHERE `id`='$srow->id' LIMIT 1";if (mysqli_query($link, $bquery)) {}
$tquery = "INSERT INTO `".$main['tbl_orders_traded']."` VALUES (NULL, '$brow->member_id', '$srow->member_id', '$brow->symbol', '$brow->symbolb', '$brow->amount', '$brow->price', '2', ".time().")";if (mysqli_query($link, $tquery)) {}


if ($tbquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$brow->member_id' AND `symbol`='$brow->symbolb') ORDER BY `member_id` DESC LIMIT 1") {
if($tbresult = mysqli_query($link, $tbquery)) {
if (mysqli_num_rows($tbresult) >= 1) {//print 'aaa';
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+$brow->amount WHERE (`member_id`='$brow->member_id' AND `symbol`='$brow->symbolb') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}else{//print 'bbb';
$tbuquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$brow->member_id', '0', '$brow->symbolb', '$brow->amount', '')";
if (mysqli_query($link, $tbuquery)) {}
}
}
}

if ($tsquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$srow->member_id' AND `symbol`='$brow->symbol') ORDER BY `member_id` DESC LIMIT 1") {
if($tsresult = mysqli_query($link, $tsquery)) {
if (mysqli_num_rows($tsresult) >= 1) {//print 'ccc';
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+($brow->amount*$brow->price) WHERE (`member_id`='$srow->member_id' AND `symbol`='$brow->symbol') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}else{//print 'ddd';
$tbuquery = "INSERT INTO `".$main['tbl_balances']."` VALUES (NULL, '$srow->member_id', '0', '$brow->symbol', '".($brow->amount*$brow->price)."', '')";
if (mysqli_query($link, $tbuquery)) {}
}
}
}

$brow->amount=0;
$srow->amount-=$brow->amount;
}

//print '<br>';
}
mysqli_free_result($iresult);
}
}


}
mysqli_free_result($jresult);
}
}
//_______________-=TheSilenT.CoM=-_________________
*/
//ALL FIEDLS

$ba = 0;
$bp = 0;
$bs = 0;
$bf = 0;
$bt = 0;

$sa = 0;
$sp = 0;
$ss = 0;
$sf = 0;
$st = 0;

if (isset($_upost['ba'])) { $ba = $_upost['ba'];}
if (isset($_upost['bp'])) { $bp = $_upost['bp'];}
if (isset($_upost['bs'])) { $bs = $_upost['bs'];}
if (isset($_upost['bf'])) { $bf = $_upost['bf'];}
if (isset($_upost['bt'])) { $bt = $_upost['bt'];}

if (isset($_upost['sa'])) { $sa = $_upost['sa'];}
if (isset($_upost['sp'])) { $sp = $_upost['sp'];}
if (isset($_upost['ss'])) { $ss = $_upost['ss'];}
if (isset($_upost['sf'])) { $sf = $_upost['sf'];}
if (isset($_upost['st'])) { $st = $_upost['st'];}
//_______________-=TheSilenT.CoM=-_________________
//CANCEL ORDER

//_______________-=TheSilenT.CoM=-_________________
//VALIDATE && UPDATE PAIRS
$allcoins=array();
$minimumtrade=array();
$query = "SELECT * FROM `".$main['tbl_coins']."` WHERE `id` ORDER by `id` ASC LIMIT ".$main['max_deposits'];
if ($result = mysqli_query($link, $query)) {
if (mysqli_num_rows($result) >= 1) {
while ($coins = mysqli_fetch_object($result)) {
$allcoins[]=$coins->symbol;	
$minimumtrade[$coins->symbol]=$coins->amount;
}
mysqli_free_result ($result);
}
}



foreach ($allcoins as $val) {
foreach ($allcoins as $ival) {
if ($ival != $val) {
	//print $val.' '.$ival.' ';
$pquery = "SELECT * FROM `".$main['tbl_pairs']."` WHERE (`symbol`='$val' AND `symbolb`='$ival') ORDER by `id` DESC LIMIT 10";
if ($presult = mysqli_query($link, $pquery)) {
if (mysqli_num_rows($presult) <= 0) {
	//print 'zzzz';
$oquery = "SELECT * FROM `".$main['tbl_pairs']."` WHERE (`symbol`='$ival' AND `symbolb`='$val') ORDER by `id` DESC LIMIT 10";
if ($oresult = mysqli_query($link, $oquery)) {
if (mysqli_num_rows($oresult) <= 0) {
	//print 'saaasasas';
$dquery = "INSERT INTO `".$main['tbl_pairs']."` VALUES (NULL, '$val', '$ival',".time().")";
if (mysqli_query($link, $dquery)) {}
}
}

}
}

}
}
}





//_______________-=TheSilenT.CoM=-_________________
//LIST PAIRS

$pquery = "SELECT * FROM `".$main['tbl_pairs']."` WHERE `id` ORDER by `id` ASC LIMIT 1000";
if ($presult = mysqli_query($link, $pquery)) {
if (mysqli_num_rows($presult) >= 1) {

print '<table><tr><td>';
while ($orow = mysqli_fetch_object($presult)) {
print '<a class="pairs" href="?s='.$orow->symbol.'&t='.$orow->symbolb.'">'.$orow->symbol.' '.$orow->symbolb.'</a> ';
}
mysqli_free_result($presult);
print '</td></tr></table>';

}
}


//_______________-=TheSilenT.CoM=-_________________
//
if (!isset($_uget['s']) and !isset($_uget['t'])) {
	$_uget['s']='DOGE';
	$_uget['t']='SLOTH';
}



if (isset($_uget['s']) and isset($_uget['t'])) {
$s = alphnum($_uget['s']);
$t = alphnum($_uget['t']);

if (in_array($s,$allcoins) and in_array($t,$allcoins)) {

$pquery = "SELECT * FROM `".$main['tbl_pairs']."` WHERE (`symbol`='$s' AND `symbolb`='$t') ORDER by `id` DESC LIMIT 1";
if ($presult = mysqli_query($link, $pquery)) {
if (mysqli_num_rows($presult) >= 1) {
if ($prow = mysqli_fetch_object($presult)) {


$bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$row->id' AND `symbol`='$s') ORDER by `id` DESC LIMIT 1";
if ($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
if ($srow = mysqli_fetch_object($bresult)) {
}
}else{
	$srow = new stdClass();
	$srow->amount=0;
}
}

$bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`member_id`='$row->id' AND `symbol`='$t') ORDER by `id` DESC LIMIT 1";
if ($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
if ($trow = mysqli_fetch_object($bresult)) {
}
}else{
	$trow = new stdClass();
	$trow->amount=0;
}
}

if (isset($_upost['action'])) {
//_______________-=TheSilenT.CoM=-_________________
//BUY ORDER
if (preg_match("/^buy/sim",$_upost['action']) && $ba >= 1 && $bp >= 0.00000001) {
//print 'aaa';
$bs = ($ba * $bp);
$bf = ($bs/(100)*$tradingfee);
$bt = $bs+($bs/(100)*$tradingfee);
//print "$srow->amount > 0 AND $bt > 0 AND $bt >= ".($minimumtrade[$prow->symbol]/100)." AND $srow->amount >= $bt AND $bt <= $srow->amount";
if ($srow->amount > 0 AND $bt > 0 AND $bt >= ($minimumtrade[$prow->symbol]/100) AND $srow->amount >= $bt AND $bt <= $srow->amount) {
$dquery = "INSERT INTO `".$main['tbl_orders_buy']."` VALUES (NULL, '$row->id', '0', '$prow->symbol', '$prow->symbolb', '$ba', '$bp', '1', ".time().")";
if (mysqli_query($link, $dquery)) {}
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`-$bt WHERE (`member_id`='$row->id' AND `symbol`='$prow->symbol') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
$srow->amount -= $bt;
}else{
	//print 'Minimum order is '.($minimumtrade[$prow->symbol]/10).' '.$prow->symbol;
}

}

//_______________-=TheSilenT.CoM=-_________________

if (preg_match("/^sell/sim",$_upost['action']) && $sa >= 1 && $sp >= 0.00000001) {
//_______________-=TheSilenT.CoM=-_________________
//SELL ORDER
//print 'bbb';
$ss = ($sa * $sp);
$sf = ($sa/(100)*$tradingfee);
$st= $ss+($ss/(100)*$tradingfee);
$sellingfor= $sa+($sa/(100)*$tradingfee);
if ($sellingfor <= $trow->amount) {
//$sellingfor = $trow->amount;
}
//print "$trow->amount > 0 AND $sa > 0 AND $sellingfor > 0 AND $sa >= ".($minimumtrade[$prow->symbolb]/100)." AND $sellingfor >= ".($minimumtrade[$prow->symbol]/100)." AND $trow->amount >= $sa AND $sa <= $trow->amount";
if ($trow->amount > 0 AND $sa > 0 AND $sellingfor > 0 AND $sa >= ($minimumtrade[$prow->symbolb]/100) AND $sellingfor >= ($minimumtrade[$prow->symbol]/100) AND $trow->amount >= $st AND $sellingfor <= $trow->amount) {
$dquery = "INSERT INTO `".$main['tbl_orders_sell']."` VALUES (NULL, '$row->id', '0', '$prow->symbol', '$prow->symbolb', '$sa', '$sp', '2', ".time().")";
if (mysqli_query($link, $dquery)) {}
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`-$sellingfor WHERE (`member_id`='$row->id' AND `symbol`='$prow->symbolb') LIMIT 1";
if (mysqli_query($link, $uquery)) {}
$trow->amount -= $sellingfor;
}else{
	//print 'Minimum order is '.($minimumtrade[$prow->symbolb]/10).' '.$prow->symbolb;
}

}else{
	
}
}

print<<<EOT
<script type="text/javascript">
function calb() {
var ba = Number(document.getElementById('ba').value);ba = ba || 0;
var bp = Number(document.getElementById('bp').value);bp = bp || 0;
var bs = Number(document.getElementById('bs').value);bs = bs || 0;
var bf = Number(document.getElementById('bf').value);bf = bf || 0;
var bt = Number(document.getElementById('bt').value);bt = bt || 0;

if(document.getElementById('ba').value !== "" && document.getElementById('bp').value !== "") {
bs = (ba * bp).toFixed(8);
bf = (bs/(100)*$tradingfee).toFixed(8);
bt =  ((ba * bp)+(bs/(100)*$tradingfee)).toFixed(8);
document.getElementById("bs").value= bs;
document.getElementById("bf").value= bf;
document.getElementById("bt").value= bt;
}
}


function cals() {
var sa = Number(document.getElementById('sa').value);sa = sa || 0;
var sp = Number(document.getElementById('sp').value);sp = sp || 0;
var ss = Number(document.getElementById('ss').value);ss = ss || 0;
var sf = Number(document.getElementById('sf').value);sf = sf || 0;
var st = Number(document.getElementById('st').value);st = st || 0;

if(document.getElementById('sa').value !== "" && document.getElementById('sp').value !== "") {
ss = (sa * sp).toFixed(8);
sf = (sa/(100)*$tradingfee).toFixed(8);
st =  (sa * sp).toFixed(8);
document.getElementById("ss").value= ss;
document.getElementById("sf").value= sf;
document.getElementById("st").value= st;
}
}

</script>
EOT;


//_______________-=TheSilenT.CoM=-_________________

print '<table><tr><td valign="top">';

//_______________-=TheSilenT.CoM=-_________________
//BUY FORM
print '<form method=post><table>
<tr><th colspan="3">Buy '.$t.'<br>
Minimum order is '.($minimumtrade[$prow->symbol]/100).' '.$prow->symbol.'</th></tr>

<tr><td>Available</td><td align=right>'.number_format($srow->amount,8).' '.$s.'</td></tr>
<tr><td>Amount</td><td><input type="text" id="ba" onkeyup="calb()" name="ba" value="'.number_format($ba,8).'"></td><td>'.$t.'</td></tr>
<tr><td>Price</td><td><input type="text" id="bp" onkeyup="calb()" name="bp" value="'.number_format($bp,8).'"></td><td>'.$s.'</td></tr>
<tr><td>Sum</td><td><input type="text" id="bs" onkeyup="calb()" name="bs" value="'.number_format($bs,8).'" readonly></td><td>'.$s.'</td></tr>
<tr><td>Fee</td><td><input type="text" id="bf" onkeyup="calb()" name="bf" value="'.number_format($bf,8).'" readonly></td><td>'.$s.'</td></tr>

<tr><td>Total</td><td><input type="text" id="bt" name="bt" value="'.number_format($bt,8).'" readonly></td><td>'.$s.'</td></tr>

<tr><th colspan="3"><input type="submit" name="action" value="Buy '.$t.'"></th></tr>
</table>';//<input type="hidden" name="sa" value="'.$sa.'"><input type="hidden" name="sp" value="'.$sp.'"><input type="hidden" name="ss" alue="'.$ss.'"><input type="hidden" name="sf" value="'.$sf.'">
//_______________-=TheSilenT.CoM=-_________________
//SELL ORDERS
$iquery = "SELECT * FROM `".$main['tbl_orders_sell']."` WHERE (`symbol`='$s' AND `symbolb`='$t') ORDER by `price` ASC LIMIT 100000";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
	

print '<div id="" style="overflow:auto; height:200px;"><table><tr><th colspan=5>sell orders</th></tr>';
print '<tr><th>Price('.$s.')</th><th>Amount('.$t.')</th><th>Total('.$s.')</th><th>Sum('.$s.')</th></tr>';

$ordersbuy = array();
while ($orow = mysqli_fetch_object($iresult)) {
if (!array_key_exists($orow->price, $ordersbuy)) {
	$ordersbuy[$orow->price] = $orow->amount;
}else{
	$ordersbuy[$orow->price] += $orow->amount;
}
}
mysqli_free_result($iresult);

$sumi=0;$sami=0;
foreach ($ordersbuy as $key => $val) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
$sumi=($key*$val);
$sami+=$sumi;
print '<tr'.$bg.'>
<td align=right>'.number_format($key,8).'</td>
<td align=right>'.number_format($val,8).'</td>
<td align=right>'.number_format($sumi,8).'</td>
<td align=right>'.number_format($sami,8).'</td>
</tr>';
}

print '</table></div>';


}
}

//_______________-=TheSilenT.CoM=-_________________

print '</td><td valign="top">';

//_______________-=TheSilenT.CoM=-_________________
//SELL FORM
print '<table>
<tr><th colspan="3">Sell '.$t.'<br>
Minimum order is '.($minimumtrade[$prow->symbolb]/100).' '.$prow->symbolb.' & '.($minimumtrade[$prow->symbol]/100).' '.$prow->symbol.'</th></tr>

<tr><td>Available</td><td align=right>'.number_format($trow->amount,8).' '.$t.'</td></tr>
<tr><td>Amount</td><td><input type="text" id="sa" onkeyup="cals()" name="sa" value="'.number_format($sa,8).'"></td><td>'.$t.'</td></tr>
<tr><td>Price</td><td><input type="text" id="sp"  onkeyup="cals()" name="sp" value="'.number_format($sp,8).'"></td><td>'.$s.'</td></tr>
<tr><td>Sum</td><td><input type="text" id="ss"  onkeyup="cals()" name="ss" value="'.number_format($ss,8).'" readonly></td><td>'.$s.'</td></tr>
<tr><td>Fee</td><td><input type="text" id="sf"  onkeyup="cals()" name="sf" value="'.number_format($sf,8).'" readonly></td><td>'.$t.'</td></tr>

<tr><td>Total</td><td><input type="text" id="st" name="st" value="'.number_format($st,8).'" readonly></td><td>'.$s.'</td></tr>
<tr><th colspan="3"><input type="submit" name="action" value="Sell '.$t.'"></th></tr>
</table></form>';//<input type="hidden" name="ba" value="'.$ba.'"><input type="hidden" name="bp" value="'.$bp.'"><input type="hidden" name="bs" value="'.$bs.'"><input type="hidden" name="bf" value="'.$bf.'">
//_______________-=TheSilenT.CoM=-_________________
//BUY ORDERS
$iquery = "SELECT * FROM `".$main['tbl_orders_buy']."` WHERE (`symbol`='$s' AND `symbolb`='$t') ORDER by `price` ASC LIMIT 100000";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
	

print '<div id="" style="overflow:auto; height:200px;"><table><tr><th colspan=5>buy orders</th></tr>';
print '<tr><th>Price('.$s.')</th><th>Amount('.$t.')</th><th>Total('.$s.')</th><th>Sum('.$s.')</th></tr>';

$ordersbuy = array();
while ($orow = mysqli_fetch_object($iresult)) {
if (!array_key_exists($orow->price, $ordersbuy)) {
	$ordersbuy[$orow->price] = $orow->amount;
}else{
	$ordersbuy[$orow->price] += $orow->amount;
}
}
mysqli_free_result($iresult);

$sumi=0;$sami=0;
foreach ($ordersbuy as $key => $val) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
$sumi=($key*$val);
$sami+=$sumi;
print '<tr'.$bg.'>
<td align=right>'.number_format($key,8).'</td>
<td align=right>'.number_format($val,8).'</td>
<td align=right>'.number_format($sumi,8).'</td>
<td align=right>'.number_format($sami,8).'</td>
</tr>';
}

print '</table></div>';


}
}


//_______________-=TheSilenT.CoM=-_________________

print '</td></tr></table>';
//_______________-=TheSilenT.CoM=-_________________

}
}
}
}

//_______________-=TheSilenT.CoM=-_________________
//MARKET HISTORY

$rquery = "SELECT * FROM `".$main['tbl_orders_traded']."` WHERE (`symbol`='$s' AND `symbolb`='$t') ORDER by `id` DESC LIMIT 10000";
if ($rresult = mysqli_query($link, $rquery)) {
if (mysqli_num_rows($rresult) >= 1) {

print '<div id="" style="overflow:auto; height:200px;"><table><tr><th colspan=5>TRADES</th></tr>';
print '<tr><th>Price('.$s.')</th><th>Amount('.$t.')</th><th>Total('.$s.')</th><th>Sum('.$s.')</th></tr>';
$sum=0;
while ($trow = mysqli_fetch_object($rresult)) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
$sum += $trow->amount*$trow->price;
print '<tr'.$bg.'>
<td align=right>'.number_format($trow->price,8).'</td>
<td align=right>'.number_format($trow->amount,8).'</td>
<td align=right>'.number_format($trow->amount*$trow->price,8).'</td>
<td align=right>'.number_format($sum,8).'</td>
</tr>';

}
mysqli_free_result($rresult);

print '</table></div>';


}
}

}
//_______________-=TheSilenT.CoM=-_________________

?>To prevent trash in the orderbook fee is taken when order is placed and not returned when cancelled. Orders that are not filled within 100 days will be cancelled.

