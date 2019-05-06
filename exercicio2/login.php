<?php
    session_start();
    $_SESSION["user"] = "Usuário";
    $username = null;
    $password = null;
    $getuser = null;
    $getpass = null;
    $auth =	FALSE;
    $errormsg =	"";


    if	($_SERVER['REQUEST_METHOD']	==	'POST')	{
        if(!empty($_POST["username"]) && !empty($_POST["password"])){
            $username =	$_POST["username"];
            $password =	$_POST["password"];
            $users = fopen("users.txt",'r') or die("Falha ao abrir arquivo!\n");

            while(!feof($users)	and	!$auth)	{
                $usersline = fgets($users);
                $getuser = strtok($usersline, ":");
                $getpass = strtok(":");
                $getpass = rtrim($getpass,"\n");
                if	(($username	== $getuser) && ($password	== $getpass)){
                    $auth = TRUE;
                }
            }

            if($auth){
                $_SESSION["user"] = $username;
                header('Location: loggedin.php');
            }else{
                $errormsg = "Usuário e/ou senha inválidos!\n";
            }
        }else{
            $errormsg =	 "Usuário e/ou senha vazios!\n";
        }
    }

?>
<!DOCTYPE	html>
<html>
<head>
    <style type="text/css">
        body {
            background-color: lightblue;
        }
        div{
            border: 2px solid;
            border-radius: 10px;
            margin: 100px auto;
            width: 40%;
            text-align: center;
        }
        input, button{
            border: 1px solid;
            border-radius: 5px;
            text-align: center;
            background-color: white;
        }
        h1{
            font-family: "Arial", Times, serif;
            color: blue;
        }

    </style>
</head>
<body>

    <div>
        <h1>Login</h1>
        <?php echo $errormsg;?>
        <form id="login" method="post">

            <input id="username" name="username" type="text" placeholder="Usuário" required><br><br>

            <input id="password" name="password" type="password" placeholder="Senha" required><br>

            <br>
            <input type="submit" value="Entrar"><br><br>

        </form>
        <button onclick="window.location.href='signin.php'">Cadastre-se</button><br><br>
    </div>
</body>
</html>
