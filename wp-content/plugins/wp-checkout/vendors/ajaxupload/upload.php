<?php

// Define a destination
$targetFolder = '../../../../uploads/wp-checkout/ajaxupload'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $targetFolder;
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	$targetFileName = time() . '.' . $fileParts['extension'];
	$targetFile = rtrim($targetPath, '/') . '/' . $targetFileName;
	
	if (move_uploaded_file($tempFile, $targetFile)) {
		echo $targetFileName;
	}
}

?>