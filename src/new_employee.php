<?php
    include 'config.php';
    include 'host.php';
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
    <title>Cadastrar Novo Funcionário</title>
</head>
    <body>
        <div class="container">
            <div class="form" style="text-align: center">
                <form action="new_employee.php" method="POST" name="newEmployeeForm" id="newEmployeeForm">
                    <h2>Cadastrar No<span>vo Funcionário</span></h2>
                    <input type="text" name="employeeName" placeholder="Nome"><br><br>
                    <label for="employeeLevel" style="margin-right: 50px;"><span style="color: grey">Permissão de administrador:</span></label><br>
                    <input type="radio" name="employeeLevel" value="Sim"> <span>Sim</span>
                    <input type="radio" name="employeeLevel" value="Não"> <span>Não</span><br>
                    <input type="text" placeholder="CPF" name="employeeCPF" onfocusout="checkCPF('<?php echo $localUrl; ?>')" id="employeeCPF"><br>
                    <script>
                        function checkCPF(url){
                            fetch(`${url}/api/check_cpf.php`, {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                                },
                                body: `cpf=${document.getElementById("employeeCPF").value}`,
                            }).then((response) => response.text())
                                .then((res) => {
                                    document.getElementById("result_cpf").innerHTML = res;
                                    letRegisterCPF();
                                });
                        }
                    </script>
                    <p id="result_cpf" style="font-style: italic; font-size: small"></p>
                    <script>
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
                    <input type="text" name="employeeLogin" placeholder="Nome de usuário"><br><br>
                    <input type="password" name="employeePassword" placeholder="Senha"><br><br>
                    <input type="submit" name="addButton" value="Cadastrar" id="addButton" class="saveButton" style="margin-left: 120px">
                </form>
            </div>
        </div>
    </body>
</html>

<?php
    if(@$_REQUEST['addButton'] == "Cadastrar") {
        @$employeeName = $_POST["employeeName"];
        @$employeeLevel = $_POST["employeeLevel"];
        @$employeeCPF = $_POST["employeeCPF"];
        @$employeeLogin = $_POST["employeeLogin"];
        @$employeePassword = md5($_POST['employeePassword']);

        if(@$employeeLevel == "Sim"){
            $isAdm = 1;
        } else {
            $isAdm = 0;
        }

        $sql = "INSERT INTO funcionario (isAdm, nome, cpf, login, password) 
                    VALUES ('$isAdm', '$employeeName', '$employeeCPF', '$employeeLogin', '$employeePassword')";


        if (mysqli_query($con, $sql)) {
            echo "Cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar";
        }
    }
?>
