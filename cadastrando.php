<?php
 $conexao = mysqli_connect("localhost", "root", "","cadastros");

 if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
  }

?>
<html>
	<head>
		<title>Cadastrando...</title>
		
		<meta charset="utf-8"/>
		
		<link rel="stylesheet" href="./css/index.css"/>
		
		<link rel="icon" href="./img/icon.png" />
		
		<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Dosis" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
		
		<link rel="stylesheet" type="text/css" href="./bootstrap/css/bootstrap.min.css"/>
		
	</head>
	<body>
<?php
if(isset($_POST['username'])){
	if(isset($_FILES['portrait'])){	
		$nome=trim($_POST['nome']);
		$sobrenome=trim($_POST['sobrenome']);
		$sexo=$_POST['sexo'];
		$turma=$_POST['turma'];
		$email=$_POST['email'];
		$username=trim($_POST['username']);
		$senha=$_POST['senha'];
		$confirm=$_POST['csenha'];
		$portrait=$_FILES['portrait']['tmp_name'];  
		$errosenha = $nomevazio = $errouser = $sucesso = $userexist = $erroturma = false;
		
		//coluna salt - segurança de senha
		$salt = rand();
		$senha_crip = hash('sha512',$senha.$salt);
		
		if($nome == ""){
			$nomevazio = true;
			echo "<br/><h1 id='msg'>Nome inválido. </h1> <br/>";
		}
		if($senha != $confirm ){
			$errosenha = true;
			echo "<br/><h1 id='msg'>Senhas não correspondem!!! </h1> <br/>";
		}
		if($username == "" or substr_count($username," ")!=0){
			$errouser = true;
			echo "<br/><h1 id='msg'>Usuário inválido. <br/> Insira um nome de usuário válido. </h1> <br/>";
		}
		if($turma == ""){
			$erroturma = true;
			echo "<br/><h1 id='msg'>Turma em branco. </h1> <br/>";
		}
		
		 $query="SELECT * FROM usuarios";
		 //echo $username;
 
		if ($usuario = mysqli_query($conexao, "SELECT * FROM usuarios WHERE username = '$username'")){
			 $row = mysqli_num_rows(mysqli_query($conexao, $query));
			 $row_igual = mysqli_num_rows($usuario);
			 //echo $row_igual;
			 $id = $row+1;
			
			if($errosenha == false && $nomevazio == false && $errouser == false && $erroturma == false){
				if($row_igual==0){
					if(!(file_exists('usuarios/'.$username))){
					
						$dir=mkdir('usuarios/'.$username);
					
						if($dir==1){
							
							$dst='usuarios/'.$username.'/portrait.jpeg'; 
									
							move_uploaded_file($_FILES['portrait']['tmp_name'],$dst);
							
							$sql = mysqli_query($conexao,"INSERT INTO usuarios(id,nome,sobrenome,sexo,turma,email,username,senha,salt) VALUES($id,'$nome', '$sobrenome', '$sexo', '$turma',    '$email', '$username', '$senha_crip',$salt)") or die("Erro ao tentar cadastrar registro");
							$sucesso = true;
						}
					}
					else{
						$userexist = true;
					}
				}
				else{
					echo "<br/><h1 id='msg'>Usuário já cadastrado. </h1> <br/> <a href='entrar.html'><button class='logar'>Fazer login</button></a>";
				}	
			}				
		}		
			 mysqli_free_result($usuario);
		}
		else {
			echo "Erro inserindo novo valor. Listando erros ... <br>";
			echo "<pre>";
			print_r(mysqli_error_list($conexao));
			echo "</pre>";
		}
	 
		mysqli_close($conexao);
		
	}
	//echo $sucesso;
if($sucesso == true){
	echo "<br/><h1 id='msg'>Cadastro Efetuado com Sucesso</h1> <br/> <a href='entrar.html'><button class='logar'>Fazer login</button></a>";
	mysqli_close($conexao);
}
elseif($userexist = true){
	echo "Não foi possível realizar seu cadastro pois a pasta do usuário já existe";
}
else{
	echo "Não foi possível realizar seu cadastro, por favor, revise seus dados";
}
if($errosenha == true or $nomevazio == true or $errouser == true ){
	echo " <a href='cadastrar.html'><button class='logar'>Cadastrar</button></a>";
}
?>
	</body>
</html>