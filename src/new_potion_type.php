<?php
    include 'config.php';
    include 'logged_user_nav_bar.php';

        @$url_id = mysqli_real_escape_string($con, $_SESSION['login']);
        $sql = "SELECT login FROM cliente WHERE login = '{$url_id}'";
        $result = mysqli_query($con, $sql);

        $sql2 = "SELECT login FROM funcionario WHERE login = '{$url_id}'";
        $result2 = mysqli_query($con, $sql2);

        if(mysqli_num_rows($result) > 0){
            header("Location: logged_index.php");
            exit;
        }

        if(mysqli_num_rows($result2) > 0){
            if (@$_SESSION['isAdm'] == 0){
                header("Location: logged_index.php");
                exit;
            }
        }
?>
    <!doctype html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="css/register_style.css">
        <title>Cadastrar Novo Tipo</title>
    </head>
    <body>
    <div class="container">
        <div class="form" style="align-content: center; justify-content: center; text-align: center">
            <form action="new_potion_type.php" method="POST" name="newPotionTypeForm" id="newPotionTypeForm">
                <h2>Cadastrar novo<span> tipo de poção</span></h2>
                <input type="text" name="potionTypeName" placeholder="Nome"><br><br>
                <textarea id="potionTypeEffect" name="potionTypeEffect" placeholder="Efeito da poção"></textarea><br><br>
                <input type="submit" name="addButton" value="Cadastrar" class="saveButton" style="margin-left: 120px">
            </form>
        </div>
    </div>
    </body>
    </html>

<?php
if(@$_REQUEST['addButton'] == "Cadastrar") {
    @$potionTypeName = $_POST["potionTypeName"];
    @$potionTypeEffect = $_POST["potionTypeEffect"];


    $sql = "INSERT INTO tipo (nome, efeito) 
                    VALUES ('$potionTypeName', '$potionTypeEffect')";


    if (mysqli_query($con, $sql)) {
        echo "Cadastrado com sucesso.";
    } else {
        echo "Erro ao cadastrar";
    }
}
?>