<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
if(isset($_SESSION['login_id']))
	header("location:index.php?page=home");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $_SESSION['system']['name'] ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
			font-family: 'Segoe UI', sans-serif;
		}
		body, html {
			height: 100%;
			width: 100%;
			overflow: hidden;
			background: #fff;
		}
		#wrapper {
			display: flex;
			height: 100vh;
			align-items: center;
			justify-content: center;
			position: relative;
			background: url('https://i.ibb.co/G5v3Z3j/blood-donation-bg.jpg') no-repeat center center;
			background-size: cover;
		}
		.overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(255, 255, 255, 0.7);
			backdrop-filter: blur(4px);
			z-index: 0;
		}
		.card {
			background: white;
			padding: 2em;
			border-radius: 16px;
			box-shadow: 0 10px 40px rgba(0,0,0,0.2);
			width: 360px;
			animation: slideFade 1.2s ease;
			position: relative;
			z-index: 2;
		}
		.card h3 {
			text-align: center;
			color: #b71c1c;
			margin-bottom: 1em;
			animation: fadeIn 2s ease-in;
		}
		.form-group {
			margin-bottom: 1em;
		}
		label {
			display: block;
			margin-bottom: 0.4em;
			font-weight: bold;
			color: #333;
		}
		input {
			width: 100%;
			padding: 0.6em;
			border: 1px solid #ccc;
			border-radius: 8px;
			transition: 0.3s;
		}
		input:focus {
			border-color: #d32f2f;
			outline: none;
			box-shadow: 0 0 5px rgba(211,47,47,0.5);
		}
		button {
			width: 100%;
			padding: 0.6em;
			background: #d32f2f;
			color: white;
			font-weight: bold;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			transition: transform 0.2s ease, background 0.3s;
		}
		button:hover {
			background: #b71c1c;
			transform: scale(1.03);
		}
		.alert {
			color: white;
			background-color: #d32f2f;
			padding: 0.5em;
			margin-bottom: 1em;
			border-radius: 6px;
			text-align: center;
		}
		@keyframes slideFade {
			from {
				opacity: 0;
				transform: translateY(50px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
		@keyframes fadeIn {
			from { opacity: 0; }
			to { opacity: 1; }
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<div class="overlay"></div>
		<div class="card">
			<h3><?php echo $_SESSION['system']['name'] ?></h3>
			<form id="login-form">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" id="username" name="username" required>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" required>
				</div>
				<button type="submit" id="login-btn">Login</button>
			</form>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$('#login-form').submit(function(e){
			e.preventDefault();
			$('#login-btn').attr('disabled', true).text('Logging in...');
			if($(this).find('.alert').length)
				$(this).find('.alert').remove();
			$.ajax({
				url:'ajax.php?action=login',
				method:'POST',
				data:$(this).serialize(),
				error:err=>{
					console.log(err)
					$('#login-btn').removeAttr('disabled').text('Login');
				},
				success:function(resp){
					if(resp == 1){
						location.href ='index.php?page=home';
					}else{
						$('#login-form').prepend('<div class="alert">Username or password is incorrect.</div>')
						$('#login-btn').removeAttr('disabled').text('Login');
					}
				}
			});
		});
	</script>
</body>
</html>
