<html>
    <head>
        <link href="css/register_style.css" rel="stylesheet">
        <title>Gerenciar Poção</title>
    </head>
<?php
    include 'config.php';
    include 'logged_user_nav_bar.php';
    @$userLogin = $_SESSION['login'];
    @$userId = $_SESSION['id'];

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


    @$potionId = $_GET['id'];

    $sql = "SELECT * FROM potion WHERE id = $potionId";
    $result = mysqli_query($con, $sql);
    $data = mysqli_fetch_array($result);

   
        if($result != null){
            echo "<div class=\"container\">";
            echo "<form action=\"\" method=\"POST\">";
            $potionId = $data['id'];
            echo "<input type=\"hidden\" value=\"$potionId\" name=\"potionId\">";
            $nome =$data['nome'];
            echo "<br><label for='nomePotion' style=\"margin-right: 258px;\"><span>Nome</span></label><br>";
            echo "<input type=\"text\" name=\"nomePotion\" id=\"inputNome\" maxlength=\"60\" value=\"$nome\"><br><br>";
            $preco =$data['preco'];
            echo "<labeL for='preco' style=\"margin-right: 258px;\"><span>Preço</span></labeL><br>";
            echo "<input type=\"text\" name=\"preco\" id=\"preco\" maxlength=\"60\" value=\"$preco\"><br><br>";
            @$tipoId = $row['tipo'];
            echo '<label for="potionType" style="margin-right: 200px;"><span>Tipo da poção</span></label><br>';
            $sqlGet = "SELECT nome FROM tipo ORDER BY nome ASC";
            $resultGet = mysqli_query($con, $sqlGet);
            echo '<select name="potionType" id="potionType">';
            while($row = mysqli_fetch_array($resultGet)){
                echo "<option style='color: grey' value='{$row['nome']}'>" . $row['nome'] . "</option>";
            }
            echo '</select>';
            echo '<br><br>';
            echo "<input type=\"submit\" name=\"botao\" id=\"update\" value=\"Salvar\" class=\"loginButton\" style='margin-left: 130px'><br> ";
            echo "</form>";
            echo "</div>";
        } else {
            echo "There is no potion.";
            header("Refresh:7");
        }

if(@$_REQUEST['botao'] == "Salvar"){
    @$potionType = $_POST["potionType"];

    @$getPotionTypeId = mysqli_query($con, "SELECT id FROM tipo WHERE nome = '".@$potionType."'");
    while(@$resultCategory = mysqli_fetch_array($getPotionTypeId)){
        @$typeId = @$resultCategory['id'];
    }
    $insere = "UPDATE potion SET 
        nome = '{$_POST['nomePotion']}'
        , preco = '{$_POST['preco']}'
        , tipo = '$typeId'
        WHERE id = $potionId";
        $result_update = mysqli_query($con, $insere);
        if ($result_update){
            echo "<h2> Anúncio $postId atualizado com sucesso!!!</h2>";
            echo "<script>top.location.href=\"menu_employee.php\"</script>";
        } else {
            echo "<h2> Não consegui atualizar!!!</h2>"; 
        }  
    exit; 
}
?>
</html>
