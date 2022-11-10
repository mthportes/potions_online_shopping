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
		
		$query = "SELECT * FROM funcionario WHERE login = '$login' AND password = '$password' ";
		$result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0){
            while ($coluna=mysqli_fetch_array($result)) {
                $_SESSION["id"]= $coluna["id"];
                $_SESSION["login"] = $coluna["login"];
                $_SESSION["isAdm"] = $coluna["isAdm"];

                $cargo = $coluna['isAdm'];
                if($cargo == "0"){
                    header("Location: menu_employee.php");
                    exit;
                }
                if($cargo == "1"){
                    header("Location: menu_employee.php");
                    exit;
                }
            }
        } else {
            echo '<script>
                    alert("Usuário e/ou senha incorretos. Por favor, tente novamente.");
                    header("Location: login.php");
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
				<input type="submit" name="button" value="Login" class="loginButton" style="margin-left: 170px;"><br>
			</form>
		</div>
	</body>
</html>