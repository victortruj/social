<?php 
session_start();
require('funciones.php');
require('clases/clases.php');
verificar_session();

require('header.php');

if(isset($_GET['CodPost']))
{
    $notificaciones = new notificaciones();

	$notificaciones->vistas($_GET['CodPost']);

	$post = new post();
	$post = $post->mostrar_por_codigo_post($_GET['CodPost']);
	require('publicacion.php');
}




 ?>



 </body>
 </html>