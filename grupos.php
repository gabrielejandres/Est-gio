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
		<title>Grupos do usuário - N@melab</title>
		
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
			.nomes{
				color: black;
			}
			.chat{	
				width: 500px;
				margin: 150px auto;
				padding: 5px;
				background:rgba(0,0,0,0.5);
				color:rgba(255,255,255,1);
				border:rgba(255,255,255,0.6) solid 1.5px;
				text-decoration: none;
				font-family: 'Josefin Sans', sans-serif;
			}
			.destinatario{
				background: rgba(31, 31, 139, 0.5);
				color: white;
				padding: 5px;
			}
			#ent{
				margin-top: -55px;
				float: right;
				margin-right: 10px;
			}
			.chat:hover{
				background-color:rgba(0,0,0,0.8);
			}
			.botao{
				background-color: black;
				opacity: 0.8;
				border-radius: 10px;
				padding: 5px;
				font-family: 'Josefin Sans', sans-serif;
			}
			.lado{
				margin-top: -500px;
			}
		</style>
		
	</head>
	<body>
		<div class="chat">
			<div class="destinatario">
				<?php
					echo "<center> Meus Grupos <center/>";
				?>
			</div>
			<div class="mensagens">
				<?php	
					$username = $_SESSION['username'];
					$sqli = mysqli_query($conexao,"SELECT nome,sobrenome FROM usuarios where username != '$username'") or die("Erro ao procurar usuarios");
					$i=0;
					while($arrayUsuarios= mysqli_fetch_array($sqli)){
							$nomes[$i] = $arrayUsuarios['nome'] . " " . $arrayUsuarios['sobrenome'];
							//print_r($arrayUsuarios);
							$i++;
					}
					
					//print_r($nomes);
					$username = $_SESSION['username'];
					//echo $username;

					$sql = mysqli_query($conexao,"SELECT * FROM usuarios WHERE username = '$username' ") or die("Erro ao procurar usuario");
					$arrayUsuario = mysqli_fetch_array($sql);
					//print_r($arrayUsuario);
					$id = $arrayUsuario['id'];
					//echo $id;
					$sql2 = mysqli_query($conexao,"SELECT id_grupo FROM adicaonogp WHERE id_participante = '$id' ") or die("Erro ao procurar id");
					$a=0;
					while($arrayGrupos = mysqli_fetch_array($sql2)){
						$grupos[$a] = $arrayGrupos['id_grupo'];
						$a++;
					}
					//print_r($grupos);

					if(isset($grupos)){
						for($i=0;$i<count($grupos);$i++){
						$sqlnomes = mysqli_query($conexao,"SELECT nome FROM grupos WHERE id = '$grupos[$i]'") or die("Erro ao procurar nome do grupo");
						$arraygps = mysqli_fetch_array($sqlnomes);
						echo "<center>";
						echo $arraygps['nome'];
						?>
						<form action = 'adcgrupo.php' method="post" >
							<select name='novo_membro' class="nomes">
							  <option disabled selected>Adicionar um novo participante</option>
							  <?php
							  	for($u=0;$u<count($nomes);$u++){
									?> <option value='<?php echo $u; ?>'> <?php echo $nomes[$u]; ?> </option>
								<?php }?>
							</select>

							<input type="hidden" name="idgp" value="<?php echo $grupos[$i];?>"/><?php
								$_SESSION['idgp'] = $grupos[$i];
							?>

							<input type="submit" name="adc" value='Adicionar' class="botao">
						</form>
						<form action = 'mensagemgp.php' method="post" >
							<input type="hidden" name="idgp" value="<?php echo $grupos[$i];?>"/> <?php
								$_SESSION['idgp'] = $grupos[$i];
							?>
							<input type="submit" name="adc" value='Enviar mensagem' class="botao">
						</form>
						
						<br/>
						<?php
							
						}
					}
					else{
						echo "<center>Infelizmente você ainda não pertence a um grupo.<center/>";
						echo "<br/>";
					}
						echo "<br/>";
						echo "<center><button class='botao'><a href='novogrupo.php'>Criar um novo grupo</a></button><center/>";
						echo "<br/>";

				?>
			</div>
		</div>
		<button class="cad"><a href="home.php">Voltar</a></button>
		<?php
			mysqli_close($conexao);
		?>
	</body>
</html>
