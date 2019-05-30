<?php

//_______________-=TheSilenT.CoM=-_________________
$allcoins=array();
if ($bquery = "SELECT * FROM `".$main['tbl_coins']."` WHERE `id` ORDER BY `amount` DESC LIMIT 10") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {
while ($brow = mysqli_fetch_object ($bresult)) {
$allcoins[]=$brow->symbol;
}
mysqli_free_result ($bresult);
}
}
}



//_______________-=TheSilenT.CoM=-_________________
//LADDERS
print '<table><tr><th>#</th>';
foreach ($allcoins as $val) {
	print '<th><a href=?q='.$val.'>'.$val.'</a></th>';
}
print '</tr><tr>';

print '<td valign=top>';
for ($i=1;$i<10;$i++) {
	print $i.'.<br>';
}
print '</td>';

foreach ($allcoins as $val) {
if(empty($bg)){$bg=' class="darkgrey"';}else{$bg='';}
print '<td'.$bg.' valign="top" align="right">';

if ($bquery = "SELECT * FROM `".$main['tbl_balances']."` WHERE `symbol`='$val' ORDER BY `amount` DESC LIMIT 10") {
if($bresult = mysqli_query($link, $bquery)) {
if (mysqli_num_rows($bresult) >= 1) {

while ($brow = mysqli_fetch_object ($bresult)) {
print number_format($brow->amount,2).'<br>';

}
mysqli_free_result ($bresult);

}
}
}
print '</td>';
}

print '</tr></table>';

//_______________-=TheSilenT.CoM=-_________________

?>