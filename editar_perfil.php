<?php 
session_start();
require('funciones.php');
require('clases/clases.php');
verificar_session();

    $usuarios = new usuarios();

	$usuario = $usuarios->usuario_por_codigo($_SESSION['CodUsua']);
	$imagenActual = $usuario['foto_perfil'];


	if(isset($_POST['editar']))
	{
		$destino = 'subidos/';
		$nuevaImagen = !empty($_FILES['foto']['name']) ? $destino . $_FILES['foto']['name'] : $usuario['foto_perfil'];
		$tmp = $_FILES['foto']['tmp_name'];
		$datos = array(
				$_POST['nombre'],
				$_POST['usuario'],
				$_POST['profesion'],
				$_POST['pais'],
				$nuevaImagen
			);

		if(strpos($datos[1], " ")  == false)
		{
			$edito =$usuarios->editar($_SESSION['CodUsua'], $datos);

			//si se edito el perfil y la nueva imagen es diferente de la actual
			if($edito && $nuevaImagen!=$imagenActual){
                move_uploaded_file($tmp, $nuevaImagen);
            }

			header('location: editar_perfil.php');
		}
	}

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Editar Perfil</title>
 	<link rel="stylesheet" href="css/login.css">
 </head>
 <body>
 	<div class="contenedor-form">
 		<h1>Editar perfil</h1>
 		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post">
 			<input type="text" name="nombre" class="input-control" value="<?php echo $usuario["nombre"]; ?>">
 			<input type="text" name="usuario" class="input-control" value="<?php echo $usuario["usuario"]; ?>">
 			<input type="text" name="profesion" class="input-control" value="<?php echo $usuario["profesion"]; ?>">
 			<input type="text" name="pais" class="input-control" value="<?php echo $usuario["pais"]; ?>">

 			<input type="file" name="foto" >
 			<input type="submit" value="Editar" name="editar" class="log-btn">
 		</form>
 		<div class="registrar">
 			<a href="perfil.php?CodUsua=<?php echo $_SESSION['CodUsua']; ?>">Volver al perfil</a>
 		</div>
 	</div>
 </body>
 </html>