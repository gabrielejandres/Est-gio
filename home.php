<?php

$conexao = mysqli_connect("localhost", "root", "","cadastros");

 if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
 }

?>
<?php
	session_start();

	if(isset($_SESSION['username'])){
			$username = $_SESSION['username'];
			//echo $username;

			$sql = mysqli_query($conexao,"SELECT * FROM usuarios WHERE username = '$username' ") or die("Erro ao procurar usuario");
			$array1 = mysqli_fetch_array($sql);
			$arrayUsuario = mysqli_fetch_array($sql);
			print_r($arrayUsuario);
			
			$usuario['nome'] = $array1['nome'];
			$usuario['sobrenome'] = $array1['sobrenome'];
			$usuario['sexo'] = $array1['sexo'];
			$usuario['turma'] = $array1['turma'];
			$usuario['username'] = $array1['username'];
			$usuario['id'] = $array1['id'];
			$usuario['email'] = $array1['email'];

			//print_r($usuario);

			$turma = $usuario['turma'];
			//echo $id;
			$sql = mysqli_query($conexao,"SELECT * FROM usuarios WHERE turma = '$turma'") or die("Erro ao procurar sua turma");

			$i = 0;
			while( $linha = mysqli_fetch_array($sql)){
					if($linha['nome'] != $usuario['nome'] && $linha['sobrenome'] != $usuario['sobrenome']){
						$amigos[$i]['nome'] = $linha['nome'] . ' '.  $linha['sobrenome'];
						$amigos[$i]['id'] = $linha['id'];
						//echo $amigos[$i]."<br/>";
						$i++;
				}
			}
			//print_r($usuario);
	}
	else{
		header("Location: erros.php");
		die();
	}
		
?>

<html>
	<head>
		<title>Perfil do usuário - N@melab</title>
		
		<meta charset="utf-8"/>
		
		<link rel="stylesheet" href="./css/index.css"/>
		
		<link rel="icon" href="./img/icon.png" />
		
		<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"/>
		
		<?php
			$perfil = "usuarios/".$usuario['username']."/portrait.jpeg";
		?>
		<style rel="stylesheet" type="text/css">
			.lista{
				background-color: rgba(255,255,255,0.4);
				border-radius: 20px;
				text-align: center;
				width: 250px;
				margin-left: 1090px;
				color: #000;
				font-family: 'Josefin Sans', sans-serif;
			}
			.enviar_msg{
				position: absolute;
				margin-top: 240px;
				margin-left: 750px; 
				border-radius:25px;
				width: 150px;
				padding: 5px;
				background:rgba(0,0,0,0.7);
				color:rgba(255,255,255,0.8);
				border:rgba(255,255,255,0.8) solid 1.5px;
				text-decoration: none;
				font-family: 'Pacifico', cursive;
			}
			.imgmenu{
				float: left;
				margin-top: -0.5%;
			}
			.menu li:last-child{
				margin-left: 10%;
				font-size: 1.1em;
				background-color: rgba(255,255,255,0.3);
				padding: 5px;
				border-radius: 45%;
			}
			
			.header{
				height: 15%;
			}
			.perfil{
				border-radius: 50%;
				margin-left: 7%;
				float: left;
				max-width: 100%;
				margin-right: 3%;
				margin-bottom: 3%;
			}
			.botao{
				background-color: black;
				color: white;
				opacity: 0.8;
				border-radius: 10px;
				padding: 5px;
				font-family: 'Josefin Sans', sans-serif;
			}
			.informations{
				font-family: 'Josefin Sans', sans-serif;
				padding: 1%;

			}
			#autoria{
				font-family: 'Josefin Sans', sans-serif;
				margin-left: 500px;
				float: left;
				color: #000;
				border-radius: 50px;
				width: 400px;
				text-align: center;
				opacity: 0.6;
			}
			#autoria p{
				font-size: 16px;
			}
			#autoria:hover{
				color:rgba(0,0,0,0.7);
			}
			.menu2{
					text-align: center;		
					background-color:#0B6138;
					float: left;
					width: 100%;
					height: 50px;
					padding-top: 15px;
					margin-top: -15px;
					margin-top: 10px;
			}
			.primeiro, .segundo, .terceiro, .licenciatura{
				float: left;
				margin-top: 40px;
				background-color: rgba(255,255,255,0.4);
				border-radius: 20px;
				text-align: center;
				width: 160px;
				color: #000;
				font-family: 'Josefin Sans', sans-serif;
			}

		</style>
		<script src="./JS/jquery.min.js"></script>
	</head>
	<body>
	<header class="header">
	<img class="imgmenu" src="./img/logo.png" alt="logo">
		<div class="menu">
				<?php if($_SESSION['username'] != "guttmann"){?>
				<nav>
					<ul>
						<li><a href="index.html" >Página Inicial</a></li>
						<li><a href="sobre.html">Sobre</a></li>
						<li><a href="atividades.html">Atividades</a></li>
						<li><a href="grupos.php">Grupos</a></li>		
						<li><a href="logout.php">Sair</a></li>	
					</ul>
				</nav>
			<?php }
			else{ ?>
				<nav>
					<ul>
						<li><a href="index.html" >Página Inicial</a></li>
						<li><a href="grupos.php">Grupos</a></li>
						<li><a href="controle_conv.php">Controle de conversas</a></li>
						<li><a href="controle_ativ.php">Controle de atividade</a></li>		
						<li><a href="logout.php">Sair</a></li>	
					</ul>
				</nav>
				<?php } ?>
		</div>
	</header>
	<div class="meuperfil">
		<div>
			<img src="<?php echo $perfil;?>" class="perfil"/>
		</div>
		<div class="informations">
			<h1><?php 
				echo $usuario['nome'] . " ";
				echo $usuario['sobrenome'];
			?></h1>
			<h3 class="information"><?php 
				echo "Sexo:" . " " . $usuario['sexo'];
				echo "<br/>";
			?></h3>
			<h3 class="information"><?php 
				echo "Usuário:" . " " .  $usuario['username'];
				echo "<br/>";
			?></h3>
			<?php  if($_SESSION['username'] != "guttmann"){ ?>
			<h3 class="information"><?php 
				echo "Turma:" . " " .  $usuario['turma'];
				echo "<br/>";
			}?></h3>
			
		</div>
			<?php
			//echo $_SESSION['username'];
			 if($_SESSION['username'] != "guttmann"){?>
				<div class="lista">
					<h1> Minha turma </h1>
			<?php 
			//print_r($amigos);
			//echo count($amigos);

			if(isset($amigos)){
				for($a=0; $a < count($amigos); $a++){
					//print_r($amigos);
					echo $amigos[$a]['nome'];
					$idamigo = $amigos[$a]['id'];?>
					<form action="mensagem.php" method="post">
						<input type="hidden" name="id" value="<?php echo $idamigo;?>"/>
						
						<input class="botao" type="submit" value="Enviar mensagem"/>
					</form>
					<?php	
				}}
			}
			else{?>
				<div class="primeiro"> 
				<h1> 1° Ano </h1>
			<?php
				$sql = mysqli_query($conexao,"SELECT * FROM usuarios where turma = 'primeiro'") or die("Erro ao procurar usuario");

				while( $usuarios = mysqli_fetch_array($sql)){
					//print_r($usuarios);
					echo $usuarios['nome'] . " " . $usuarios['sobrenome'];
					$idamigo = $usuarios['id'];?>
					<form action="mensagem.php" method="post">
						<input type="hidden" name="id" value="<?php echo $idamigo;?>"/>
						
						<input class="botao" type="submit" value="Enviar mensagem"/>
					</form>
					<?php	
					}?>
				</div>
				<div class="segundo">
				<h1> 2° Ano </h1>
			<?php
				$sql = mysqli_query($conexao,"SELECT * FROM usuarios where turma = 'segundo'") or die("Erro ao procurar usuario");

				while( $usuarios = mysqli_fetch_array($sql)){
					//print_r($usuarios);
					echo $usuarios['nome'] . " " . $usuarios['sobrenome'];
					$idamigo = $usuarios['id'];?>
					<form action="mensagem.php" method="post">
						<input type="hidden" name="id" value="<?php echo $idamigo;?>"/>
						
						<input class="botao" type="submit" value="Enviar mensagem"/>
					</form>
					<?php	
					}?>
				</div>
				<div class="terceiro">
				<h1> 3° Ano </h1>
			<?php
				$sql = mysqli_query($conexao,"SELECT * FROM usuarios where turma = 'terceiro'") or die("Erro ao procurar usuario");

				while( $usuarios = mysqli_fetch_array($sql)){
					//print_r($usuarios);
					echo $usuarios['nome'] . " " . $usuarios['sobrenome'];
					$idamigo = $usuarios['id'];?>
					<form action="mensagem.php" method="post">
						<input type="hidden" name="id" value="<?php echo $idamigo;?>"/>
						
						<input class="botao" type="submit" value="Enviar mensagem"/>
					</form>
					<?php	
					}?>
				</div>
				<div class="licenciatura">
				<h1> Licenciatura </h1>
			<?php
				$sql = mysqli_query($conexao,"SELECT * FROM usuarios where turma = 'licenciatura'") or die("Erro ao procurar usuario");

				while( $usuarios = mysqli_fetch_array($sql)){
					//print_r($usuarios);
					echo $usuarios['nome'] . " " . $usuarios['sobrenome'];
					$idamigo = $usuarios['id'];?>
					<form action="mensagem.php" method="post">
						<input type="hidden" name="id" value="<?php echo $idamigo;?>"/>
						
						<input class="botao" type="submit" value="Enviar mensagem"/>
					</form>
					<?php	
					}?>
				</div>
				<?php
				}	
			?>
		</div>
	<br/>
	</div>
	<footer>
		<div class="menu2">
			<div id="autoria">
				<p> © Created by Ana Clara Faria & Gabriele Jandres</p>
			</div>
		</div>
	</footer>
		
	</body>
</html>
<?php}
		mysqli_close($conexao);
		?>