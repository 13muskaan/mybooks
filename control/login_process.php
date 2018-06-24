<?php 

session_start();
include ('../model/dbconnection.php'); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = !empty($_POST['email']) ? test_user_input(($_POST['email'])) : null;
	$password = !empty($_POST['password']) ? test_user_input(($_POST['password'])) : null;
	try {
			$stmt = $conn->prepare("SELECT password FROM users WHERE email = :user");
			$stmt->bindParam(':user', $email);
			$stmt->execute();
			$rows = $stmt ->fetch(PDO::FETCH_ASSOC)['password'];
				if (password_verify($password, $rows)) {
					$stmt = $conn->prepare("SELECT usersID, role FROM users WHERE email = :user");
					$stmt->bindParam(':user', $email);
					$stmt->execute();
								$user = $stmt->fetch(PDO::FETCH_ASSOC);	
									if ($user['role'] == '3') {
									$_SESSION['Login'] = $user['role'];
									header('location:sessions.php?role=' . $user['role']);
									header('location: /view/pages/viewbooks.php');
								}
									if ($user['role'] == '2') {
									$_SESSION['Login'] = $user['role'];
									header('location:sessions.php?role=' . $user['role']);
									header('location: /view/pages/viewbooks.php');

								}
									
							}
		else{
			header('location:../view/pages/login.php');
		}
	} catch (Exception $e) {
		
	}
}
?>
