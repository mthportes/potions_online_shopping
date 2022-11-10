<html>
	<head>
		<title>Login</title>
		<link href="css/login_style.css" rel="stylesheet">
	</head>
	<?php
	include ('config.php');
	include 'navigation_bar.php';
	session_start(); 

	if (@$_REQUEST['button']=="Login")
	{
		$login = $_POST['login'];
		$password = md5($_POST['password']);
		
		$query = "SELECT * FROM cliente WHERE login = '$login' AND password = '$password' ";
		$result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while ($coluna=mysqli_fetch_array($result))
            {
                $_SESSION["id"]= $coluna["id"];
                $_SESSION["login"] = $coluna["login"];
                header("Location: menu.php");
            }
        } else {
            echo '<script>
                    alert("Usuário e/ou senha incorretos. Por favor, tente novamente.");
                    header("Location: login_cliente.php");
                  </script>';
        }
	}
	?>

	<body>
		<div class="container">
			<h1>Seja <span>bem vindo</span></h1>
			<form class="user" action=# method=post>
				<input type="text" aria-describedby="emailHelp" placeholder="Nome de usuário" name="login"><br><br>
				<input type="password" id="password" placeholder="Senha" name="password"> <br><br>
				<a href="register_cliente.php"><button type="button" class="registerButton">Seja um cliente!</button></a>
				<input type="submit" name="button" value="Login" class="loginButton"><br>
			</form>
		</div>
	</body>
</html>