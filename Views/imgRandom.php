<?php
$d = opendir('images/girls/');
$filelist = array();
while ($filename=readdir($d)) {
    if ($filename!='.' && $filename!='..') {
        $filelist[]=$filename;}
}
closedir ($d);
$rand = array_rand($filelist);

?>