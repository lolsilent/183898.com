<?php

//_______________-=TheSilenT.CoM=-_________________

//UPDATE ACCOUNT

if (!empty($_upost['email']) && !empty($_upost['password']) && !empty($_upost['pin']) && !empty($_upost['nemail']) && !empty($_upost['npassword']) && !empty($_upost['npin']) && !empty($_upost['update'])) {
$email_hash = $_upost['email'];
$password_hash = $_upost['password'];
$pin_hash = $_upost['pin'];

if ($row->email == $email_hash && $row->password == $password_hash && $row->pin == $pin_hash) {
$nemail_hash = $_upost['nemail'];
$npassword_hash = $_upost['npassword'];
$npin_hash = $_upost['npin'];

//wtf("$nemail_hash $npassword_hash $npin_hash $email_hash $password_hash $pin_hash");

$uquery = "UPDATE `".$main['tbl_members']."` SET `email`='$nemail_hash',`password`='$npassword_hash',`pin`='$npin_hash' WHERE `id`='$row->id' LIMIT 1";

if (mysqli_query($link, $uquery)) {
	print 'updated';
}
}
}else{

print '<form method=post action="?f=account"><input type="password" name="email" size="20" maxlength="128" value="" placeholder="email">
<input type="password" name="password" size="20" maxlength="128" value="" placeholder="password">
<input type="password" name="pin" size="20" maxlength="32" value="" placeholder="secret pin">
<input type="submit" size="20" name="update" value="login">
<br>
<input type="password" name="nemail" size="20" maxlength="128" value="" placeholder="NEW email">
<input type="password" name="npassword" size="20" maxlength="128" value="" placeholder="NEW password">
<input type="password" name="npin" size="20" maxlength="32" value="" placeholder="NEW secret pin">
<input type="submit" size="20" name="update" value="update"></form>';

}
//_______________-=TheSilenT.CoM=-_________________


//LOGOUT

print '<form method=post>
<input type="password" name="pin" size="20" maxlength="32" value="" placeholder="secret pin">
<input type="submit" size="20" name="logout" value="logout"></form>';


//_______________-=TheSilenT.CoM=-_________________
?>