<?php
session_start();

$files = $_SESSION[$_GET['f']];

$zip = new ZipArchive();

$tmp_file = tempnam('.','');
$zip->open($tmp_file, ZipArchive::CREATE);

for($j = 0; $j < count($files['pdf_file']); $j++) {
  $download_file = file_get_contents($files['pdf_file'][$j]);
  $zip->addFromString(basename($files['pdf_file'][$j]), $download_file);
}

$zip->close();

header('Content-disposition: attachment; filename='.$_SESSION[$_GET['f'].'_name'].'.zip');
header('Content-type: application/zip');
readfile($tmp_file);

unlink($tmp_file);
?>