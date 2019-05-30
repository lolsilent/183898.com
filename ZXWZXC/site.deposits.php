<?php

//_______________-=TheSilenT.CoM=-_________________

//UNCONFIRMED DEPOSITS

$iquery = "SELECT * FROM `".$main['tbl_unconfirmed']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT ".$main['max_deposits'];
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

print '<table><tr><th colspan=5>last '.$main['max_deposits'].' unverified deposits</th></tr>';
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

$iquery = "SELECT * FROM `".$main['tbl_deposits']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT ".$main['max_deposits'];
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {
	

print '<table><tr><th colspan=5>last '.$main['max_deposits'].' verified deposits</th></tr>';
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

