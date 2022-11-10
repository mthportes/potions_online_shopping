<!doctype html>
    <?php
        include 'config.php';
        include 'logged_user_nav_bar.php';

        @$userLogin = $_SESSION['login'];
        @$userId = $_SESSION['id'];


        $sql2 = "SELECT login FROM funcionario WHERE login = '{$url_id}'";
        $result2 = mysqli_query($con, $sql2);

        if(mysqli_num_rows($result2) > 0){
            header("Location: logged_index.php");
            exit;
        }
    ?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/register_style.css" rel="stylesheet">
    <title>Bem vindo</title>
</head>
<body>
    <?php
        $sql = "SELECT * FROM cliente WHERE id = $userId";
        $result = mysqli_query($con, $sql);
        $data = mysqli_fetch_array($result);
            if($result != null){
                echo "<div class=\"row\">";
                echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";
                echo "<div class=\"column\">";       
                echo "<div class=\"card\">";
                echo "<div class=\"upper-line\">";
                echo "</div>";
                echo "<div class=\"container\">";
                if($data['avatar'] != null){
                    echo '<img class="userAvatar" src="uploaded_img/'.$data['avatar'].'" id="myImg"><br><br>';
                } else {
                    echo '<img class="userAvatar" src="img/no-image.png" id="myImg"><br><br>';
                }
                echo '<label for="avatar" class="avatarButton" id="avatarUpload" name="avatar"> Escolha seu avatar </label>';
                echo '<input name="avatar" id="avatar" type="file" accept="image/jpg, image/jpeg, image/png" style="display: none"/>';
                echo '<script>
                        const fileInput = document.getElementById(\'avatar\');

                            fileInput.onchange = function(e){
                                if(e.target.files.length > 0){
                                    document.getElementById(\'avatarUpload\').style.backgroundColor = \'purple\';
                                    document.getElementById(\'avatarUpload\').innerText = "Atualizando...";
                                    document.getElementById(\'avatarUpload\').style.color = \'white\';
                                    document.getElementById("myImg").src = "./img/loading.gif";
                                    setInterval(function () {
                                        document.getElementById("myImg").style.height = "150px";
                                        document.getElementById("myImg").src = "./img/check.png";
                                        document.getElementById(\'avatarUpload\').innerText = "Atualizado. Selecionar outro...";
                                        document.getElementById("myImg").style.backgroundColor = "white";                   
                                    }, 5000);
                                }
                            }
                       </script>';
//                echo '<input type="file" name="avatar" id="avatar" accept="image/jpg, image/jpeg, image/png">';
                $nome =$data['nome'];
                echo "<h4><b> Nome: <input type=\"text\" name=\"nome\" id=\"inputNome\" maxlength=\"80\" placeholder=\"Digite seu nome\" value=\"$nome\" required></b></h4>";
                $login =$data['login'];
                echo "<h4><b> Login: <input type=\"text\" name=\"login\" id=\"inputLogin\" maxlength=\"60\" value=\"$login\" required></b></h4>";
                $password =$data['password'];
                echo "<h4><b> Senha: <input type=\"password\" name=\"password\" id=\"password\" maxlength=\"80\" required></b></h4>";
                $cpf =$data['cpf'];
                echo "<h4><b> CPF: <input type=\"text\" name=\"cpf\" id=\"inputCPF\" maxlength=\"80\" placeholder=\"$cpf\" value=\"$cpf\" disabled></b></h4>";
                echo "<input type=\"submit\" name=\"botao\" id=\"update\" value=\"Salvar\" class=\"loginButton\"><br> ";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                echo "</form>";
                    
                echo "</div>";
            } else {
                echo "Error find Client.";
                header("Refresh:7");
            }
    
    if(@$_REQUEST['botao'] == "Salvar"){
        $password = md5($_POST['password']);  
        if($_FILES['avatar']['name'] != ''){
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
            $insere = "UPDATE cliente SET 
             nome = '{$_POST['nome']}'
            , login = '{$_POST['login']}'
            , password = '$password'
            , avatar = '$new_name'
            WHERE id = $userId";
            $result_update = mysqli_query($con, $insere);
            if ($result_update){
                move_uploaded_file($image_tmp_name, $image_folder);
                echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                echo "<script>top.location.href=\"cliente_profile.php\"</script>";
            } else {
                echo "<h2> Não consegui atualizar!!!</h2>"; 
            }  
        exit; 
        } else{
            $insere = "UPDATE cliente SET 
             nome = '{$_POST['nome']}'
            , login = '{$_POST['login']}'
            , password = '$password'
            WHERE id = $userId";
            $result_update = mysqli_query($con, $insere);
            if ($result_update){
                move_uploaded_file($image_tmp_name, $image_folder);
                echo "<h2> Perfil atualizado com sucesso!!!</h2>";
                echo "<script>top.location.href=\"cliente_profile.php\"</script>";
            } else {
                echo "<h2> Não consegui atualizar!!!</h2>"; 
            }  
        exit; 
        }  
        
    }
    ?>
</body>
</html>
