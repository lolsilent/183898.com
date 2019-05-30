<?php
try {

//_______________-=TheSilenT.CoM=-_________________

require_once('ZXWZXC/www.main.php');
require_once('ZXWZXC/www.functions.php');
require_once('ZXWZXC/www.json.php');
include_once('ZXWZXC/www.header.php');

//_______________-=TheSilenT.CoM=-_________________


if (!isset($_uget['f']) || empty($_uget['f'])) {

if (!isset($row) || empty($row->email) || !isset($row->email)) {
$_uget['f'] = 'index';
}else{
$_uget['f'] = 'trade';
}

}


if (in_array($_uget['f'], $files)) {
	include_once('ZXWZXC/site.'.$_uget['f'].'.php');
}


include_once('ZXWZXC/www.footer.php');

//_______________-=TheSilenT.CoM=-_________________

} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
