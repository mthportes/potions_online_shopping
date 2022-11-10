<?php
    include 'logged_user_nav_bar.php';
    include 'config.php';

    @$url_id = mysqli_real_escape_string($con, $_SESSION['login']);
    $sql = "SELECT login FROM cliente WHERE login = '{$url_id}'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
        header("Location: logged_index.php");
        exit;
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
        <title>Cadastrar Nova Poção</title>
    </head>
    <body>
        <div class="container">
            <div class="form">
                <form action="new_potion.php" method="POST" name="newPotionForm" id="newPotionForm">
                    <h2>Cadastrar nova<span> poção</span></h2>
                    <input type="text" name="potionName" placeholder="Nome"><br><br>
                    <input type="float" name="potionPrice" placeholder="Preço"><br><br>
                    <label for="potionType" style="margin-right: 150px;"><span>Tipo da poção</span></label><br>
                    <?php
                    $sqlGet = "SELECT nome FROM tipo ORDER BY nome ASC";
                    $resultGet = mysqli_query($con, $sqlGet);
                    echo '<select name="potionType" id="potionType">';
                    while($row = mysqli_fetch_array($resultGet)){
                        echo "<option style='color: grey' value='{$row['nome']}'>" . $row['nome'] . "</option>";
                    }
                    echo '</select>';
                    ?>
                    <br><br>
                    <input type="submit" name="addButton" value="Cadastrar" class="saveButton" style="margin-left: 120px">
                </form>
            </div>
        </div>
    </body>
</html>

<?php
if(@$_REQUEST['addButton'] == "Cadastrar") {
    @$potionName = $_POST["potionName"];
    @$potionPrice = $_POST["potionPrice"];
    @$potionType = $_POST["potionType"];

    @$getPotionTypeId = mysqli_query($con, "SELECT id FROM tipo WHERE nome = '".@$potionType."'");
    while(@$resultCategory = mysqli_fetch_array($getPotionTypeId)){
        @$typeId = @$resultCategory['id'];
    }

    $sql = "INSERT INTO potion (nome, preco, tipo) 
                    VALUES ('$potionName', '$potionPrice', $typeId)";


    if (mysqli_query($con, $sql)) {
        echo "Cadastrado com sucesso.";
        header('Location: new_potion.php');
        die();
    } else {
        echo "Erro ao cadastrar";
    }
}
?>