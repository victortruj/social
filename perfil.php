<?php 
session_start();
require('funciones.php');
require('clases/clases.php');
verificar_session();
require('header.php');

if(isset($_GET['CodUsua']))
{
    $usuarios = new usuarios();
	$usuario = $usuarios->usuario_por_codigo($_GET['CodUsua']);
	if(empty($usuario)) {
        header('location: index.php');
    }

    $amigos = new amigos();
	$verificar_amigos = $amigos->verificar($_SESSION['CodUsua'], $_GET['CodUsua'] );

	$post = new post();
	$post = $post->post_por_usuario($_GET['CodUsua']);
}

if(isset($_GET['agregar']))
{
    $amigos = new amigos();
	$amigos->agregar($_SESSION['CodUsua'], $_GET['CodUsua']);
	header('location: perfil.php?CodUsua='.$_GET['CodUsua']);
}



if(isset($_POST['comentario']))
{
	if(!empty($_POST['comentario']))
	{
	    $comentarios = new comentarios();
		$comentarios->agregar($_POST['comentario'], $_SESSION['CodUsua'], $_POST['CodPost']);

		$notigicaciones = new notificaciones();
		$notigicaciones->agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']);
		header('location: index.php');
	}
}

if(isset($_GET['mg']))
{
    $mg = new mg();
	$mg->agregar($_GET['CodPost'], $_SESSION['CodUsua']);

	$notigicaciones = new notificaciones();
	$notigicaciones->agregar(false, $_GET['CodPost'], $_SESSION['CodUsua']);
	header('location: index.php');
}

 ?>


<div id="perfil">
	<ul>
		<li><img src="<?php echo $usuario['foto_perfil']; ?>" alt="" id="img"></li>
		<li>
			<h3><?php echo $usuario['nombre']; ?></h3>
			<ul>
				<li>Edad: <span><?php echo $usuario['edad']; ?></span></li>
				<li>Profesion: <span><?php echo $usuario['profesion']; ?></span></li>
				<li>Pais: <span><?php echo $usuario['pais']; ?></span></li>
				<li>Amigos: <span>
					<?php
                        $amigos = new amigos();
                        echo $amigos->cantidad_amigos($_GET['CodUsua']);
					 ?>
				</span></li>
			</ul>
		</li>
	<?php if($_GET['CodUsua'] != $_SESSION['CodUsua']): ?>
		<?php if(empty($verificar_amigos)): ?>
			<li><a href="perfil.php?CodUsua=<?php echo $_GET['CodUsua']; ?>&&agregar=<?php echo $_GET['CodUsua']; ?>">Agregar</a></li>
		<?php elseif($verificar_amigos[0]['status'] == true): ?>
			<li><a href="#">Amigos</a></li>
		<?php else: ?>
			<li><a href="#">Solicitud enviada</a></li>
		<?php endif; ?>
	<?php else: ?>
		<li><a href="editar_perfil.php">Editar</a></li>
	<?php endif; ?>
	</ul>

</div>


<?php require('publicacion.php'); ?>

 </body>
 </html>