
<?php 
session_start();
require('funciones.php');
require('clases/clases.php');

$user = new usuarios();


	if(isset($_POST['acceder']))
	{
		$pass = hash('sha512', $_POST['pass']);
		$datos = array(limpiar($_POST['usuario']), $pass);

		

		if(datos_vacios($datos) == false)
		{

			if(strpos($datos[0], " ") == false)
			{
				
				
				$resultados = $user->verificar($datos[0]);

				if(empty($resultados) == false)
				{


				
					echo "<pre>";
			
					if($datos[1] == $resultados['pass'])
					{


						$_SESSION['CodUsua'] = $resultados["CodUsua"];
						$_SESSION['nombre'] = $resultados["nombre"];
						$_SESSION['foto_perfil'] = $resultados['foto_perfil'];
						header('location: index.php');
					}
				}
			}
		}else{
			$error = "No ingreso ningun dato";
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<div class="contenedor-form">
	<h1>
		Login
	</h1>
		<?php 
			if (!empty($error)) {
				echo "<br><small>".$error."</small>";
			}		
		?>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="text" name="usuario" class="input-control" placeholder="usuario">
			<input type="password" name="pass" class="input-control" placeholder="Password">
			<input type="submit" value="Acceder" name="acceder" class="log-btn">
		</form>
		<div class="registrar">
			<a href="registro.php">Eres nuevo?</a>
		</div>
	</div>
</body>
</html>