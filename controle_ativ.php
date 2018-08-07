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
		<title>Usuários mais ativos - N@melab</title>
		
		<meta charset="utf-8"/>
		
		<link rel="stylesheet" href="./css/index.css"/>
		
		<link rel="icon" href="./img/icon.png" />
		
		<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"/>

		<style rel="stylesheet" type="text/css">
			*{
				font-family: 'Josefin Sans', sans-serif;
			}
			a{
				color: white;
			}
			a:hover{
				color: white;
			}

		</style>
		
	</head>
		<body>
		<div class="caixa">
			<img class="logo "src="./img/logo.png"/>
			<h1 class="title"> Usuários mais ativos </h1>
			<?php
				$sql = mysqli_query($conexao,"SELECT remetente FROM mensagens") or die("Erro ao procurar ids");
				$i=0;
				while( $ids = mysqli_fetch_array($sql)){
					//print_r($usuarios);
					$usuarios[$i] = $ids['remetente'];
					//print_r($ids);
					$i++;
					}
					//print_r($usuarios);
					$frequencia = array_count_values($usuarios);
					arsort($frequencia);
					//print_r($frequencia);
				$a = 0;
				while($a < count($frequencia)){
					$indice = key($frequencia);
					//echo $indice;
					$sql = mysqli_query($conexao,"SELECT nome, sobrenome FROM usuarios where id='$indice'") or die("Erro ao procurar ids");
					$usuario = mysqli_fetch_array($sql);
					echo $usuario['nome'] . " " . $usuario['sobrenome'] . ":" . " " . $frequencia[$indice] . " " . "mensagens <br/>";
					//print_r($usuario);
					next($frequencia);
					$a++;
				}

			?>
		</div>

		<button class="cad"><a href="home.php">Voltar</a></button>
		<?php
			mysqli_close($conexao);
		?>
	</body>
</html>