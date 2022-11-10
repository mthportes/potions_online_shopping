<?php
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        die( header( 'location: index.php' ) );
    }
?>
<link rel="stylesheet" href="css/navigation_bar_style.css">
<ol>
    <img style="float: left;" src="img/potion-one.gif" alt="LEAKY CAULDRON" height="100" width="120"/>
    <div style="margin-top: 30px; margin-right: 30px">
        <li><p><span>LEAKY</span> CAULDRON</p></li>
        <li style="float: right"><a href="register_cliente.php">Cadastre-se</a></li>
        <li class="dropdown" style="float: right">
            <a href="javascript:void(0)" class="dropbtn">Entrar</a>
            <div class="dropdown-content">
                <a href="login_cliente.php">Sou cliente</a>
                <a href="login.php">Sou funcionário</a>
            </div>
        </li>
        <li style="float: right"><a href="index.php">Inicial</a></li>
    </div>
</ol>