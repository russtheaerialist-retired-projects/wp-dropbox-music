<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/

// Define a destination
$targetFolder = '/uploads'; // Relative to the root
$email = $_POST['email'];
$name = $_POST['name'];

$email_path = md5($email);
$name_path = metaphone($name);

$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
$baseDirectory = rtrim($targetPath,'/') . '/'. $email_path . '/';

if (!is_dir($baseDirectory)) {
    mkdir($baseDirectory, 0777, true);
}

$txt = fopen($baseDirectory . $name_path . ".txt", "a");
fwrite($txt, "From: " . $name . " <" . $email . ">\r\n\r\n");

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
        $targetFile = $baseDirectory . $_FILES['Filedata']['name'];

	// Validate the file type
	$fileTypes = array('mp3'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
        fwrite($txt, "File: " . $_FILES['Filedata']['name'] . "\r\n");

	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
fclose($txt);
?>
