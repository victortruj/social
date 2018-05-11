<?php 
require('funciones.php');
require('clases/clases.php');

if( isset($_GET['CodAm']) and isset($_GET['accion'])) {
//    imprimeVar($_GET);

    $amigos = new amigos();

	if($_GET['accion'] == 1)
	{
		$amigos->aceptar($_GET['CodAm']);
	}
	else
	{
		$amigos->eliminar_solicitud($_GET['CodAm']);
	}

    header('location: index.php');
}
?>
