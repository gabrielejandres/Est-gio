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
		
	</head>
	<?php
		if(isset($_POST['novo_membro'])){
			$username = $_SESSION['username'];
			$id = $_POST['novo_membro']; 
			$id_grupo = $_POST['idgp'];
			//echo $id;
			$sql = mysqli_query($conexao,"select id from usuarios where username != '$username'");
			//$array1 = mysqli_fetch_array($sql);
			//print_r($array1);

			$i=0; 
			while($arrayUsuarios= mysqli_fetch_array($sql)){
				if($i == $id){
					$id_participante = $arrayUsuarios['id'];
				}
				$users[$i] = $arrayUsuarios['id'];
				$i++;
			}
			//echo $id_participante;
			//print_r($users);
			//$username = $array1['username'];
			//echo $id_grupo;
			//echo $id;
			//echo $nome;
			$insert = mysqli_query($conexao,"insert into adicaonogp(id_grupo, id_participante) values($id_grupo, $id_participante)");

			if($insert){
				echo "Membro adicionado com sucesso";
			}
			else{
				echo "O membro já pertence ao grupo";
			}

		}
	?>
	<body>
		<button class="cad"><a href="home.php">Meu Perfil</a></button>
		<?php
			mysqli_close($conexao);
		?>
	</body>
</html>