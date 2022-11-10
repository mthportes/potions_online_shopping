<?php
    include "../src/config.php";
    $login = $_POST['login'];
    $sql = "SELECT * FROM cliente";
    $result = mysqli_query($con, $sql);
    $sql2 = "SELECT * FROM funcionario";
    $result2 = mysqli_query($con, $sql2);
    while ($row = mysqli_fetch_array($result)){
        if ($login == $row['login']){
            echo "Esse login já existe em nosso sistema.";
        } else {
            echo "";
        }
    }
    while ($row2 = mysqli_fetch_array($result2)){
        if ($login == $row2['login']){
            echo "Esse login já existe em nosso sistema.";
        } else {
            echo "";
        }
    }
?>