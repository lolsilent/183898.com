<?php
/*
//_______________-=TheSilenT.CoM=-_________________
//ALL balances
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
//RESET

if (isset($_uget['reset'])) { 
$uquery = "UPDATE `".$main['tbl_balances']."` SET `amount`=10000 WHERE `id` LIMIT 100";
if (mysqli_query($link, $uquery)) {}
}
print '<a href="?f=trade&reset">reset</a>';


//_______________-=TheSilenT.CoM=-_________________
*/

if (isset($link)) {
mysqli_close($link);
}

if (isset($DEBUG) AND !empty($DEBUG)) {

isset($_GET)?wtf($_GET):'';
isset($_POST)?wtf($_POST):'';
isset($_COOKIE)?wtf($_COOKIE):'';

}
//print cookie_hash($_SERVER);

print '<br>Version 0.01 use at own risk last updated 5/12/2018 10:31:12 PM <a href="https://github.com/lolsilent">Admin SilenT</a>';
?></body></html>