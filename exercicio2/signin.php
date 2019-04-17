<?php
    $username	=	null;
    $password	=	null;
    if($_SERVER['REQUEST_METHOD']	==	'POST'){
        if(!empty($_POST["username"])	&&	!empty($_POST["password"])){
            $username	=	$_POST["username"];
            $password	=	$_POST["password"];
            $users	=	fopen("users.txt","a+")	or	die("Falha ao abrir arquivo!");
            $fileline	=	$username.":".$password.":\n";
            fwrite($users,	$fileline);
            fclose($users);
            header('Location:	login.php');
        }
    }
?>

<!DOCTYPE	html>
<html lang="en">
<body>
    <div id="page" align="center" style="border: solid 1px; width: 40%; margin: auto;">
        <h1>Cadastre-se</h1>
        <form id="login" method="post">
            <input id="username" name="username" type="text" placeholder="Usuário" required><br><br>

            <input id="password" name="password" type="password" placeholder="Senha" required><br>

            <br>
            <input type="submit" value="Cadastrar"><br><br>
        </form>
        <button onclick="window.location.href='login.php'">Voltar</button><br><br>
    </div>
</body>
</html>

<?php?>
