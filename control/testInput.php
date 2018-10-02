<?php
function SanitiseData ($data, $default = null) {
	return !empty($data) ? testUserInput($data) : $default;
}

// Test user input by sanitising input
function testUserInput ($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>