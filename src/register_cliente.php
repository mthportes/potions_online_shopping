<html>
<head>
    <title>Cadastre-se</title>
    <?php include ('config.php'); 
    include 'navigation_bar.php';
    include 'host.php'; ?>
    <link href="css/register_style.css" rel="stylesheet">
</head>
    <body>
    <?php
    $id = @$_REQUEST['id'];
    if (isset($_POST['submit'])){
        $password = md5($_POST['password']);  
        $image_name = $_FILES['avatar']['name'];
        $image_size = $_FILES['avatar']['size'];
        $image_tmp_name = $_FILES['avatar']['tmp_name'];
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        if($extension != null){
            $new_name = $_POST['login'].'.'.$extension;
        } else {
            $new_name = null;
        }
        $image_folder = "uploaded_img/".$new_name;
        if (!$_REQUEST['id']){
            $insere = "INSERT into cliente (nome, login, password, cpf, avatar) VALUES ('{$_POST['nome']}', '{$_POST['login']}', '$password',  '{$_POST['cpf']}', '$new_name')";
            $result_insere = mysqli_query($con, $insere);
            move_uploaded_file($image_tmp_name, $image_folder);
            echo "<script>alert('Cadastrado com sucesso!'); top.location.href='login_cliente.php';</script>";                
            } else {
                echo "<h2> Nao consegui inserir!!!</h2>";
            }
    }
    ?>
<div class="container">
    <h2>Cadastre<span>-se</span></h2>
    <form action="register_cliente.php" method="post" name="user" enctype="multipart/form-data">
        <input type="text" placeholder="Username" onkeyup="checkUser('<?php echo $localUrl; ?>')" name="login" id= "login" value="<?php echo @$_POST['login']; ?>" required>
        <script>
            function checkUser(url) {
                fetch(`${url}/api/check_user.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    body: `login=${document.getElementById("login").value}`,
                }).then((response) => response.text())
                    .then((res) => {
                        document.getElementById("result").innerHTML = res;
                        letRegister();
                    });
            }
        </script>
        <p id="result" style="font-style: italic; font-size: small"></p>
        <input type="text" placeholder="Nome" name="nome" value="<?php echo @$_POST['nome']; ?>" required><br>
        <input type="text" onfocusout="CalculaCPF('<?php echo $localUrl; ?>')" placeholder="CPF" name="cpf" id="cpf" value="<?php echo @$_POST['cpf']; ?>" required><br>
        <script>
            function CalculaCPF(url) {
                fetch(`${url}/api/check_cpf.php`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    body: `cpf=${document.getElementById("cpf").value}`,
                }).then((response) => response.text())
                    .then((res) => {
                        console.log("** entrei"+res);
                        document.getElementById("result_cpf").innerHTML = res;
                        letRegisterCPF();
                    });
            }
        </script>
        <p id="result_cpf" style="font-style: italic; font-size: small"></p>
        <input type="password" id="password" name="password" value="<?php echo @$_POST['password']; ?>" placeholder="Senha" required><br>
        <br>
        <label for="avatar" class="avatarButton" id="avatarUpload" name="avatar">
            Escolha seu avatar
        </label>
        <input name="avatar" id="avatar" type="file" accept="image/jpg, image/jpeg, image/png" style="display: none"/>
        <script>
            const fileInput = document.getElementById('avatar');

            fileInput.onchange = function(e){
                if(e.target.files.length > 0){
                    document.getElementById('avatarUpload').style.backgroundColor = 'purple';
                    document.getElementById('avatarUpload').innerText = "Enviado. Selecionar outro...";
                    document.getElementById('avatarUpload').style.color = 'white';
                }
            }

            function letRegister(){
                userAvaiable = document.getElementById("result").innerHTML.valueOf();
                if(userAvaiable == "Esse login já existe em nosso sistema."){
                    document.getElementById("buttonGravar").style.backgroundColor="grey";
                    document.user.button.disabled=true
                } else {
                    document.getElementById("buttonGravar").style.backgroundColor="#008CBA";
                    document.user.button.disabled=false
                }
            }
            function letRegisterCPF(){
                cpfAvaiable = document.getElementById("result_cpf").innerHTML.valueOf();
                if(cpfAvaiable == "CPF Inválido." || cpfAvaiable == "Obrigatório CPF com 11 dígitos."){
                document.querySelector('#addButton').disabled = true;
                document.getElementById("result_cpf").style.color="red";
                } else {
                    document.getElementById("result_cpf").style.color="green";
                    document.querySelector('#addButton').disabled = false;
                    }
                }
        </script>
        <br><br><input type="submit" value="Gravar" name="submit" id="addButton" class="saveButton">
        <a href="login_cliente.php">
            <button type="button" class="loginButton">Já tenho uma conta</button>
        </a>
    <input type="hidden" name="id" value="<?php echo @$_REQUEST['id'] ?>">

    </form>
</div>
    </body>
</html>