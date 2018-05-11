<?php 
session_start();
require('funciones.php');
require('clases/clases.php');
verificar_session();

require('header.php');
require('subir.php');

//imprimeVar($_GET,false);

if(isset($_POST['publicar']) and !empty($_FILES) and !empty($_POST['contenido']))
{
	$destino = 'subidos/';
	$contenido = $_POST['contenido'];
	$img = $destino . $_FILES['archivo']['name'];
	$tmp = $_FILES['archivo']['tmp_name'];
	$post = new post();
	$post->agregar($_SESSION['CodUsua'], $contenido, $img);
	move_uploaded_file($tmp, $img);
	header('location: index.php');
}


$amigos = new amigos();
$amigos = $amigos->codigos_amigos($_SESSION['CodUsua']);


$post = new post();
$post = $post->mostrarTodo($amigos['amigos']);


//imprimeVar($posts);

if(isset($_POST['comentario']))
{
	if(!empty($_POST['comentario']))
	{
		$comentarios = new comentarios();
		$comentarios->agregar($_POST['comentario'], $_SESSION['CodUsua'], $_POST['CodPost']);
		
		$notificaciones = new notificaciones();
		$notificaciones->agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']);
		header('location: index.php');
	}

}

if(isset($_GET['mg']))
{
	$mg = new mg();
	$mg->agregar($_GET['CodPost'], $_SESSION['CodUsua']);

	$notificaciones = new notificaciones();
	$notificaciones->agregar(false, $_GET['CodPost'], $_SESSION['CodUsua']);
		header('location: index.php');
}

include 'publicacion.php';

?>


	


	
 	
 </body>
 </html>