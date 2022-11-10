<!doctype html>
<?php
    include 'config.php';
    include 'logged_user_nav_bar.php';

    @$url_id = mysqli_real_escape_string($con, $_SESSION['login']);
    $sql = "SELECT login FROM cliente WHERE login = '{$url_id}'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) > 0){
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
    <link rel="stylesheet" href="css/potion_page_style.css">
    <title>Potions</title>
</head>
<body>
<ul>
    <li style="float: right; padding-top: 12px" class="buttons">
        <input type="text" id="myFilter" class="searchBar" onkeyup="myFunctionCateg()" placeholder="Procure pelo tipo">
        <input type="text" id="myFilterPrec" class="searchBar" onkeyup="myFunctionPrec()" placeholder="Procure por preço">
    </li>
</ul>
<?php
    @$userLogin = $_SESSION['login'];
    @$userId = $_SESSION['id'];
    if(!isset($_SESSION['login'])){
        echo "<script>top.location.href='index.php';</script>";
    }

echo "<script>
            function myFunctionCateg() {
              var input, filter, cards, cardContainer, title, i;
              input = document.getElementById(\"myFilter\");
              filter = input.value.toUpperCase();
              cardContainer = document.getElementById(\"myProducts\");
              cards = cardContainer.getElementsByClassName(\"card\");
              for (i = 0; i < cards.length; i++) {
                title = cards[i].querySelector(\".cardCategory\");
                if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                  cards[i].style.display = \"\";
                } else {
                  cards[i].style.display = \"none\";
                }
              }
            }

            function myFunctionPrec() {
              var input, filter, cards, cardContainer, title, i;
              input = document.getElementById(\"myFilterPrec\");
              filter = input.value.toUpperCase();
              cardContainer = document.getElementById(\"myProducts\");
              cards = cardContainer.getElementsByClassName(\"card\");
              for (i = 0; i < cards.length; i++) {
                title = cards[i].querySelector(\".cardPrice\");
                if (title.innerText.includes(filter)) {
                  cards[i].style.display = \"\";
                } else {
                  cards[i].style.display = \"none\";
                }
              }
            }
        </script>";

$sql = "SELECT * FROM potion";
$result = mysqli_query($con, $sql);

if($result != null){
    echo "<div class=\"row\" id=\"myProducts\">";
    while($row = mysqli_fetch_array($result)){
            echo "<form action=\"\" method=\"POST\">";
            echo "<div class=\"column\">";
            @$potionId = $row['id'];
            echo "<input type=\"hidden\" value=\"$potionId\" name=\"potionId\">";
            echo "<div class=\"card\">";
            echo "<div class=\"upper-line\">";
            echo "</div>";
            echo "<div class=\"container\">";
            echo "<h4><b><span>Nome:</span> ".$row['nome']."</b></h4>";
            echo "<p class=\"cardPrice\"> <span>Preco:</span> ".$row['preco']."</p>";

            @$tipoId = $row['tipo'];
            @$getTipoNome = mysqli_query($con, "SELECT nome FROM tipo WHERE id = $tipoId");
            while(@$resultTipoNome = mysqli_fetch_array($getTipoNome)){
                @$tipoNome = @$resultTipoNome['nome'];
            }

            echo "<p class=\"cardCategory\"> <span>Tipo da poção:</span> ".$tipoNome."</p>";

            // BOTÕES APENAS PARA ADMIN
            @$getUserAdmin = mysqli_query($con, "SELECT * FROM funcionario WHERE id = $userId");
            while(@$resultUserAdmin = mysqli_fetch_array($getUserAdmin)){
                @$userIsAdmin = @$resultUserAdmin['isAdm'];
            }
            if($userIsAdmin == 1){
                echo "<div class=\"buttons\">";
                echo "<a><button type=\"submit\" name=\"botao\" value=\"deletar poção\" class=\"button\">deletar poção</button></a>";
                echo "<a><button type=\"submit\" name=\"botao\" value=\"gerenciar potion\" class=\"button\">editar poção</button></a>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</form>";
    }
    echo "</div>";
} else {
    echo "There is no potions.";
    header("Refresh:7");
}

if(@$_REQUEST['botao'] == "deletar poção"){
    @$potionToDelete = $_POST['potionId'];
    
    $deletePotion = "DELETE FROM potion WHERE id = $potionToDelete";
    if (mysqli_query($con, $deletePotion)){
      echo "Poção deletada com sucesso.";
      //header("Refresh:3");
    } else {
      echo "Erro ao deletar poção.";
      //header("Refresh:3");
    }
}

if(@$_REQUEST['botao'] == "gerenciar potion"){
    @$potionToUpdate = $_POST['potionId'];
    echo "<script>top.location.href=\"update_potion.php?id=$potionToUpdate\"</script>";
}
?>
</body>
</html>
