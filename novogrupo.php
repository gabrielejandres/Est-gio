<?php

$conexao = mysqli_connect("localhost", "root", "","cadastros");

 if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
 }

   session_start();

?>
<html>
	<head>
		<title>Novo grupo - N@melab</title>
		
		<meta charset="utf-8"/>
		
		<link rel="stylesheet" href="./css/index.css"/>
		
		<link rel="icon" href="./img/icon.png" />
		
		<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"/>

		<style>
			a{
				color: white;
			}
			a:hover{
				color: white;
			}
		</style>
		
	</head>
	<?php
		if(isset($_POST['nomegp'])){
			$nome = $_POST['nomegp'];
			//echo $nome;
			$query= "insert into grupos(nome) values('$nome')";
			$insert = mysqli_query($conexao,$query) or die("Erro ao criar grupo");
			$select = mysqli_query($conexao,"SELECT id FROM grupos");
			$i=$ult=0;

					while($arrayids = mysqli_fetch_array($select)){
						if($arrayids['id'] > $ult){
							$ult = $arrayids['id'];
						}
							$i++;
					}
			
			$username = $_SESSION['username'];

			$select_id = mysqli_query($conexao,"SELECT id FROM usuarios where username = '$username'");
			$idArray = mysqli_fetch_array($select_id);
			$id = $idArray[0];

			$insert2 = mysqli_query($conexao,"insert into adicaonogp(id_grupo, id_participante) values('$ult', '$id')") or die("Erro ao criar grupo");

			if($insert && $insert2){
				header('Location: sucessocriacaogp.php');
			}

		}
	?>
	<body>
		<div class="caixa">
			<img class="logo "src="./img/logo.png"/>
			<h1 class="title"> Deseja criar um novo grupo? </h1>
			<form name="novogrupo" method="post" action="novogrupo.php"><br/>
				<input type="text" placeholder="Digite o nome do novo grupo" name="nomegp" class="box" size = 50/>	<br/><br/><br/>		
				
				<input type="submit" value="Criar" id="ent"/>
			</form>
		</div>

		<button class="cad"><a href="grupos.php">Voltar</a></button>
		<?php
			mysqli_close($conexao);
		?>
	</body>
</html>
