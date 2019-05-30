<?php

//_______________-=TheSilenT.CoM=-_________________
//WITHDRAWS


$iquery = "SELECT * FROM `".$main['tbl_withdraws']."` WHERE `member_id`='$row->id' ORDER by `id` DESC LIMIT ".$main['max_deposits'];
if ($iresult = mysqli_query($link, $iquery)) {
if (mysqli_num_rows($iresult) >= 1) {

print '<table><tr><th colspan=6>last '.$main['max_deposits'].' withdraw requests<br>can be cancelled with '.number_format($main['cancel_withdraws']/60).' minutes<br>will be processed within '.number_format($main['cancel_withdraws']*3/60).' minutes</th></tr>';
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

?>

