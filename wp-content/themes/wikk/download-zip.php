<?php
session_start();
$files = $_SESSION[$_GET['f']];

$zip = new ZipArchive();

$tmp_file = tempnam('.','');
$zip->open($tmp_file, ZipArchive::CREATE);

foreach ($files as $file) {
  $download_file = file_get_contents($file);

  $zip->addFromString(basename($file),$download_file);
}

$zip->close();

header('Content-disposition: attachment; filename='.$_SESSION[$_GET['f'].'_name'].'.zip');
header('Content-type: application/zip');
readfile($tmp_file);
?>