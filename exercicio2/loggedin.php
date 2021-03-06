<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Tarefas</title>
	<meta charset="UTF-8">
    <style type="text/css">
        body {
            background-color: lightblue;
        }
        #bem_vindo{
            border: 2px solid;
            border-radius: 10px;
            margin: auto;
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
        #incompletas{
            background-color: red;
        }
        #completas{
            background-color: green;
        }
        #titulos{
            background-color: lightgray;
        }
        table{
            width: 100%;
        }

    </style>
</head>

<body>

    <div id="bem_vindo" >
        <h1>Bem vindo,	<?php echo $_SESSION["user"]."!";?></h1>
        <button onclick="window.location.href='login.php'">Sair</button>
        <br><br>
    </div>

	<div align="center">
		<h1>Lista de Tarefas</h1>
		<button onclick="inserir()">Nova Tarefa</button>
		<hr>
	</div>

	<div id="form" align="center" style="display: none;" >
		<form id="myForm" method="get" onsubmit="salvar(this); return false;">
			<label for="titulo">Título:</label>
			<input type="text" id="titulo">

			<label for="descricao">Descrição:</label>
			<input type="text" id="descricao" >

			<label for="responsavel">Responsável:</label>
			<input type="text" id="responsavel" >

			<label for="prazo">Prazo:</label>
			<input type="date" id="prazo" >

			<input type="submit" value="Salvar">
		</form>

		<hr>
	</div>

	<div  id="conteudo">
		<table>
	  		<tr id="incompletas">
	  			<th align="center" colspan="4">Para Fazer:</th>
	  		</tr>
	  		<tr id="titulos">
			  	<th align='left'>Atividade</th>
			   	<th align='left'>Responsável</th>
			   	<th align='left'>Prazo</th>
			   	<th align='left'>Opções</th>
		  	</tr>

	 	</table>

	 	<br><br><br>

		<table>
	  		<tr id="completas">
	  			<th align="center" colspan="4">Feito:</th>
	  		</tr>
	  		<tr id="titulos">
			  	<th align='left'>Atividade</th>
			   	<th align='left'>Responsável</th>
			   	<th align='left'>Prazo</th>
			   	<th align='left'>Opções</th>
		  	</tr>
		 </table>

	</div>

	<div align="center">
		<hr>
		<p>Sistema de Desenvolvimento WEB I - Prof. Jair Cavalcanti - Desenvolvido por Emanoel Dantas - 20170069630 </p>
	</div>

	<script type="text/javascript">

		var tarefas = []; 	//Armazena as tarefas "Para fazer"

		var tarefas_feitas = [];	//Armazena as tarefas "Feito"

		//Exibe o form de cadastro de tarefas
		function inserir(){
			document.getElementById("form").style.display = "block";
		}

		//Gera o título das tabelas "Para fazer" e "Feito"
		function titulo_table(cor, tipo){
			return "<table style='width:100%'>"+
						"<tr style='background-color: "+cor+";'>"+
							"<th align='center' colspan='5'>"+tipo+":</th>"+
						"</tr>"+
				  		"<tr style='background-color: lightgray'>"+
						   "<th align='left'>Título</th>"+
						   "<th align='left'>Descrição</th>"+
						   "<th align='left'>Responsável</th>"+
						   "<th align='left'>Prazo</th>"+
						   "<th align='left'>Opções</th>"+
					  	"</tr>";
		}

		//Gera o corpo das tabelas "Para fazer" e "Feito"
		function corpo_table(feitas){

			var html = "";

			if(feitas){
				for(var i = 0; i < tarefas_feitas.length; i++) {
			  		var linha = "<tr>";
			  		linha += "<td>" + tarefas_feitas[i]["titulo"] + "</td>";
			  		linha += "<td>" + tarefas_feitas[i]["descricao"] + "</td>";
			  		linha += "<td>" + tarefas_feitas[i]["responsavel"] + "</td>";
			  		linha += "<td>" + tarefas_feitas[i]["prazo"] + "</td>";
			  		linha += "<td><button onclick='alterar("+i+",true)'>Alterar</button><button onclick='remover("+i+",true)'>Remover</button><button onclick='finalizar("+i+",true)'>Reabrir</button></td>";
			  		linha += "</tr>";
			  		html += linha;
			  	}
			}else{
				for(var i = 0; i < tarefas.length; i++) {
			  		linha = "<tr>";
			  		linha += "<td>" + tarefas[i]["titulo"] + "</td>";
			  		linha += "<td>" + tarefas[i]["descricao"] + "</td>";
			  		linha += "<td>" + tarefas[i]["responsavel"] + "</td>";
			  		linha += "<td>" + tarefas[i]["prazo"] + "</td>";
			  		linha += "<td><button onclick='alterar("+i+",false)'>Alterar</button><button onclick='remover("+i+",false)'>Remover</button><button onclick='finalizar("+i+",false)'>Finalizar</button></td>";
			  		linha += "</tr>";
			  		html += linha;
			  	}
			}

		  	html += "</table>";
			return html;
		}

		//Atualiza as listas "Para fazer" e "Feito" na página html
		function atualizar(alterar){

			//Ao clicar para alterar alguma tarefa, o conteúdo das tabelas "Para fazer" e "Feito" não aparece na página
			if(alterar){
				document.getElementById("conteudo").innerHTML = "";
			}else{
				var html = titulo_table("red", "Para fazer");

			  	html += corpo_table(false);

			  	html += "<br><br><br>";

			  	html += titulo_table("green", "Feito");

			  	html += corpo_table(true);

				document.getElementById("conteudo").innerHTML = html;
			}


		}

		//Salva uma tarefa
		function salvar(){

			//Recupera o conteúdo digitado pelo usuário
			var t1 = document.getElementById("titulo").value;
			var d1 = document.getElementById("descricao").value;
			var r1 = document.getElementById("responsavel").value;
			var p1 = document.getElementById("prazo").value;

			if(t1.trim() == ""){
				alert("Título inválido!");
				return false;
			}

			if(d1.trim() == ""){
				alert("Descrição inválida!");
				return false;
			}

			if(r1.trim() == ""){
				alert("Responsável inválido!");
				return false;
			}

			if(p1.trim() == ""){
				alert("Prazo inválido!");
				return false;
			}

			var tarefa = {titulo:t1, descricao:d1, responsavel:r1, prazo:p1};

			//Adiciona a tarefa na lista de "Para fazer"
			tarefas.push(tarefa);

			atualizar(false);

			//Reseta os campos do form de cadastro
			document.getElementById("form").style.display = "none";
			document.getElementById("titulo").value = "";
			document.getElementById("descricao").value = "";
			document.getElementById("responsavel").value = "";
			document.getElementById("prazo").value = "";

		}

		//Remove uma tarefa da lista de "Para fazer" ou "Feito"
		function remover(indice, feitas){

			if(feitas){
				tarefas_feitas.splice(indice, 1);
			}else{
				tarefas.splice(indice, 1);
			}

			atualizar(false);

		}

		//Finaliza ou Reabre uma tarefa da lista de "Para fazer" ou "Feito"
		function finalizar(indice, feitas){

			if(feitas){
				tarefas.push(tarefas_feitas[indice]);
				remover(indice,true);
			}else{
				tarefas_feitas.push(tarefas[indice]);
				remover(indice,false);
			}

			atualizar(false);
		}

		//Altera uma tarefa da lista de "Para fazer" ou "Feito"
		function alterar(indice, feitas){

			document.getElementById("form").style.display = "block";
			atualizar(true);

			if(feitas){
				document.getElementById("titulo").value = tarefas_feitas[indice]["titulo"];
				document.getElementById("descricao").value = tarefas_feitas[indice]["descricao"];
				document.getElementById("responsavel").value = tarefas_feitas[indice]["responsavel"];
				document.getElementById("prazo").value = tarefas_feitas[indice]["prazo"];

				tarefas_feitas.splice(indice, 1);
			}else{
				document.getElementById("titulo").value = tarefas[indice]["titulo"];
				document.getElementById("descricao").value = tarefas[indice]["descricao"];
				document.getElementById("responsavel").value = tarefas[indice]["responsavel"];
				document.getElementById("prazo").value = tarefas[indice]["prazo"];

				tarefas.splice(indice, 1);
			}

		}

	</script>

</body>
</html>
