<?php

//_______________-=TheSilenT.CoM=-_________________
print '<table><tr><td valign="top">';
//_______________-=TheSilenT.CoM=-_________________
//SELL ORDERS
$iquery = "SELECT * FROM `".$main['tbl_orders_sell']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT 1000";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

while ($orow = mysqli_fetch_object($iresult)) {
if (isset($_uget['sid']) && isset($_uget['csid']) && $_uget['sid'] == $orow->id && $_uget['csid'] == $orow->id){

//print 'AAA';
if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`symbol`='$orow->symbolb' AND `member_id`='$row->id') ORDER BY `symbol` DESC LIMIT 1") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
if ($brow = mysqli_fetch_object ($bresult)) {
mysqli_free_result($bresult);
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+'$orow->amount' WHERE `id`='$brow->id' LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}
}
}
}

$dquery = "DELETE FROM `".$main['tbl_orders_sell']."` WHERE `id`='".$_uget['sid']."' LIMIT 1";if (mysqli_query($link, $dquery)) {}
}else{
if (!isset($ordersbuy)) {
print '<table><tr><th colspan=5>sell orders</th></tr>';
print '<tr><th>id</th><th>amount</th><th>price</th><th>sum</th></tr>';
$ordersbuy = '';
}
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<tr'.$bg.'>
<td align=right>'.number_format($orow->id).'</td>
<td align=right>'.number_format($orow->amount,8).' '.$orow->symbolb.'</td>
<td align=right>'.number_format($orow->price,8).' '.$orow->symbol.'</td>
<td align=right>'.number_format($orow->amount*$orow->price,8).' '.$orow->symbol.'</td>
<td align=right><a href="?f=orders&'.((isset($_uget['sid']) && $_uget['sid'] == $orow->id)?'csid='.$orow->id.'&sid='.$orow->id.'">confirm':'sid='.$orow->id.'">cancel').'</a></td>
</tr>';
}
}
mysqli_free_result($iresult);

print '</table>';


}
}

//_______________-=TheSilenT.CoM=-_________________
print '</td><td valign="top">';
//_______________-=TheSilenT.CoM=-_________________
//BUY ORDERS
$iquery = "SELECT * FROM `".$main['tbl_orders_buy']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT 1000";
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

while ($orow = mysqli_fetch_object($iresult)) {
if (isset($_uget['bid']) && isset($_uget['cbid']) && $_uget['bid'] == $orow->id && $_uget['cbid'] == $orow->id){

//print 'BBB';
if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE (`symbol`='$orow->symbol' AND `member_id`='$row->id') ORDER BY `symbol` DESC LIMIT 1") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
if ($brow = mysqli_fetch_object ($bresult)) {
mysqli_free_result($bresult);
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=`amount`+'$orow->amount' WHERE `id`='$brow->id' LIMIT 1";
if (mysqli_query($link, $uquery)) {}
}
}
}
}


$dquery = "DELETE FROM `".$main['tbl_orders_buy']."` WHERE `id`='".$_uget['bid']."' LIMIT 1";if (mysqli_query($link, $dquery)) {}
}else{
if (!isset($orderssell)) {
print '<table><tr><th colspan=5>buy orders</th></tr>';
print '<tr><th>id</th><th>amount</th><th>price</th><th>sum</th></tr>';
$orderssell = '';
}
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<tr'.$bg.'>
<td align=right>'.number_format($orow->id).'</td>
<td align=right>'.number_format($orow->amount,8).' '.$orow->symbolb.'</td>
<td align=right>'.number_format($orow->price,8).' '.$orow->symbol.'</td>
<td align=right>'.number_format($orow->amount*$orow->price,8).' '.$orow->symbol.'</td>
<td align=right><a href="?f=orders&'.((isset($_uget['bid']) && $_uget['bid'] == $orow->id)?'cbid='.$orow->id.'&bid='.$orow->id.'">confirm':'bid='.$orow->id.'">cancel').'</a></td>
</tr>';
}
}
mysqli_free_result($iresult);

print '</table>';


}
}

//_______________-=TheSilenT.CoM=-_________________
print '</td></tr></table>';
//_______________-=TheSilenT.CoM=-_________________

?>

