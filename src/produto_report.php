<html>
<head>
    <title>Relatório de Produtos Cadastrados</title>
    <link rel="stylesheet" href="css/report_buttons.css">
    <link rel="stylesheet" href="css/search_bar_style.css">
    <?php
        include ('config.php');
        include 'logged_user_nav_bar.php';
        include 'host.php';

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

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td {
            height: 30px;
        }
        tr:hover{
            background-color: #f9f9f9;
        }
        th, th:hover{
            height: 50px;
            cursor: pointer;
        }
    </style>
    
    <body>
        <?php
        $quantidade = 10;
        $pagina     = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
        $inicio     = ($quantidade * $pagina) - $quantidade;

        $sql = "SELECT nome, preco, tipo FROM potion ORDER BY nome ASC LIMIT $inicio, $quantidade";
        $result = mysqli_query($con, $sql);
        $produtos = [];
        if ($result != null) {
            $produtos = $result->fetch_all(MYSQLI_ASSOC);
        }
        if (@$_REQUEST['botao'] == "Exportar arquivo"){
            $myfile = fopen("relatorios/produtos.txt", "a");
            if(!empty($produtos)){
                foreach($produtos as $produto) {
                    echo "<script> console.log(\" Entrei no foreach\")</script>";
                    @$nome = $produto['nome'];
                    @$preco = $produto['preco'];
                    @$tipoId = $produto['tipo'];
                    @$getTipoNome = mysqli_query($con, "SELECT nome FROM tipo WHERE id = $tipoId");
                    while(@$resultTipoNome = mysqli_fetch_array($getTipoNome)){
                        @$TipoNome = @$resultTipoNome['nome'];
                    } 
                    echo "<script> console.log(\"2 Entrei no foreach\")</script>";
                    $txt = "$nome $preco $TipoNome \n";
                    fwrite($myfile, $txt); 
                } 
            }
            
            fclose($myfile); 
        }
        ?>
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="&#128269 Procure por nome, preço ou tipo"
         title="Filtra a tabela" class="searchBar">
        
        <div>
            <table id="myTable" style="width: 100%; align-content: center; justify-content: center; text-align: center">
                <thead>
                <th onclick="sortTable(0)">Nome  &#8645</th>
                <th onclick="sortTable(1)">Preco  &#8645</th>
                <th onclick="sortTable(2)">Tipo  &#8645</th>
                </thead>
                <tbody>
                <?php if(!empty($produtos)) { ?>
                    <?php foreach($produtos as $produto) { ?>
                        <tr>
                            <td><?php echo $produto['nome']; ?></td>
                            <td><?php echo $produto['preco']; ?></td>
                            <?php
                            @$tipoId = $produto['tipo'];
                            @$getTipoNome = mysqli_query($con, "SELECT nome FROM tipo WHERE id = $tipoId");
                            while(@$resultTipoNome = mysqli_fetch_array($getTipoNome)){
                                @$tipoNome = @$resultTipoNome['nome'];
                            }
                            ?>
                            <td><?php echo $tipoNome; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                <p id="totalRegister" style="text-align: center"></p>
                </tfoot>
                <?php
                $sqlTotal   = "SELECT id FROM potion";
                $qrTotal    = mysqli_query($con, $sqlTotal);
                $numTotal   = mysqli_num_rows($qrTotal);
                $totalPagina= ceil($numTotal/$quantidade);
                $exibir = 3;
                $anterior  = (($pagina - 1) == 0) ? 1 : $pagina - 1;
                $posterior = (($pagina+1) >= $totalPagina) ? $totalPagina : $pagina+1;
                ?>
                <div class="navegacao" style="text-align: center">
                    <?php
                    echo '<a href="?pagina=1" style=\'text-decoration: none; color: rebeccapurple\'>primeira</a> | ';
                    echo "<a href=\"?pagina=$anterior\" style='text-decoration: none; color: rebeccapurple'> &#11013 </a> | ";
                    ?>
                    <?php
                    for($i = $pagina-$exibir; $i <= $pagina-1; $i++){
                        if($i > 0)
                            echo '<a href="?pagina='.$i.'" style=\'text-decoration: none; color: rebeccapurple\'> '.$i.' </a>';
                    }

                    echo '<a href="?pagina='.$pagina.'" style=\'text-decoration: none; color: rebeccapurple\'><strong>'.$pagina.'</strong></a>';

                    for($i = $pagina+1; $i < $pagina+$exibir; $i++){
                        if($i <= $totalPagina)
                            echo '<a href="?pagina='.$i.'" style=\'text-decoration: none; color: rebeccapurple\'> '.$i.' </a>';
                    }
                    ?>
                    <?php
                    echo " | <a href=\"?pagina=$posterior\" style='text-decoration: none; color: rebeccapurple'> &#10145 </a> | ";
                    echo "  <a href=\"?pagina=$totalPagina\" style='text-decoration: none; color: rebeccapurple'>última</a>";
                    ?>
                </div><br>
            </table>
        </div>
        <form action="#" method="POST" style="width: 97%; align-content: center; justify-content: center"><br>
            <button value="Exportar arquivo" name="botao" class="exportButton" style="float: right; margin: 10px"><a href="./relatorios/produtos.txt" download style="text-decoration: none; color: white">Exportar arquivo</a></button>
            <a href="produto_pdf.php" target="_blank"><input type="button" value="Imprimir" class="printButton" style="float: right; margin: 10px"/>
        </form>  
    </body>
    <script>
            const myFunction = () => {
                const trs = document.querySelectorAll('#myTable tr:not(.header)')
                const filter = document.querySelector('#myInput').value
                const regex = new RegExp(filter, 'i')
                const isFoundInTds = td => regex.test(td.innerHTML)
                const isFound = childrenArr => childrenArr.some(isFoundInTds)
                const setTrStyleDisplay = ({ style, children }) => {
                    style.display = isFound([
                    ...children 
                ]) ? '' : 'none' 
                }
  
                trs.forEach(setTrStyleDisplay)
            }
            var x = document.getElementById("myTable").rows.length;
            var textRegistro = (x-1) > 1 ? "registros" : "registro";
            document.getElementById("totalRegister").innerHTML = "Mostrando "+(x-1)+" "+textRegistro+".";
            function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("myTable");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                    }
                }
                }
                if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount ++;
                } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
                }
            }
            }
        </script>
</html>