<?php 

class usuarios{

	function registrar($datos)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("insert into usuarios(CodUsua, nombre, usuario, pass, pais, profesion, edad, foto_perfil) values(null, :nombre, :usuario, :pass, :pais, :profe, :edad, :foto_perfil)");
		$consulta->execute(array(':nombre' => $datos[0],
								  ':usuario' => $datos[1],
								  ':pass' => $datos[2],
								  ':pais' => $datos[3],
								  ':profe' => $datos[4],
								  ':edad' => $datos[5],
								  ':foto_perfil' => 'img/sin foto de perfil.jpg'
							));
	}


	function verificar($usuario)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select * from usuarios where usuario = '$usuario'");
		$resultado = $consulta->fetch_assoc();
		
		return $resultado;
	}

	function editar($CodUsua, $datos)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("update usuarios set nombre = :nombre, usuario = :usuario, profesion = :profesion, pais = :pais, foto_perfil = :foto_perfil where CodUsua = '$CodUsua'");
		$consulta->execute(array(':nombre' => $datos[0],
								  ':usuario' => $datos[1],
								  ':profesion' => $datos[2],
								   ':pais' => $datos[3],
								  ':foto_perfil' => $datos[4],
								  ':CodUsua' => $CodUsua

							));

		//aqui habia un error en el indice profesion
	}


	function usuario_por_codigo($CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select * from usuarios where CodUsua = :CodUsua");
		$consulta->execute(array(':CodUsua' => $CodUsua));
		$resultado = $consulta->fetch_assoc();
		return $resultado;
	}
}


class post{

	function agregar($CodUsua, $contenido, $img)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("insert into post(CodPost, CodUsua, contenido, img) values(null, '$CodUsua', '$contenido', '$img')");
	
	}


	function post_por_usuario($CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.contenido, P.img from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua = :CodUsua ORDER BY P.CodPost DESC");
		$consulta->execute(array(':CodUsua' => $CodUsua));
		$resultado = $consulta->fetch_assoc();
		return $resultado;
	}

	function mostrarTodo($amigos)
	{

		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');

		$sql = "select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.contenido, P.img from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua in($amigos) ORDER BY P.CodPost DESC";
		$consulta = $mysqli->query($sql);
		$resultado = arrayQuery($consulta);


		return $resultado;
	}

	function mostrar_por_codigo_post($CodPost)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.contenido, P.img from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodPost = :CodPost ORDER BY P.CodPost DESC");
		$consulta->execute(array(':CodPost' => $CodPost));
		$resultado = $consulta->fetch_assoc();
		return $resultado;
	}


}


class comentarios{

	function agregar($comentario, $CodUsua, $CodPost)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("insert into comentarios(comentario, CodUsua, CodPost) values(:comentario, :CodUsua, :CodPost) ");
		$consulta->execute(array(
					':comentario' => $comentario,
					':CodUsua' => $CodUsua,
					':CodPost' => $CodPost

					));
	}


	function mostrar($CodPost)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select U.nombre, C.comentario from usuarios U inner join comentarios C on U.CodUsua = C.CodUsua where C.CodPost = '$CodPost'");

		$resultado = arrayQuery($consulta);
		return $resultado;
	}
	

}



class mg
{
	function agregar($CodPost, $CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("insert into mg(CodLike, CodPost, CodUsua) values(null, :CodPost, :CodUsua)");
		$consulta->execute(array(':CodPost' => $CodPost, ':CodUsua' => $CodUsua));
	}


	function mostrar($CodPost)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select count(*) cant from mg where CodPost = '$CodPost'");
		$resultados = $consulta->fetch_assoc();

		return $resultados;
	}


	function verificar_mg($CodPost, $CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select CodLike from mg where CodPost = '$CodPost' and CodUsua = '$CodUsua'");
		$resultados = $consulta->fetch_assoc();
		return count($resultados);
	}

}



class notificaciones
{
	function agregar($accion, $CodPost, $CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("insert into notificaciones(CodNot, accion, CodPost, CodUsua, visto) values(null, :accion, :CodPost, :CodUsua, 0)");
		$consulta->execute(array(
			':accion' => $accion, 
			':CodPost' => $CodPost, 
			':CodUsua' => $CodUsua
			));
	}


	function mostrar($CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select U.CodUsua, U.nombre, N.CodNot, N.accion, N.CodPost from notificaciones N inner join usuarios U on U.CodUsua = N.CodUsua where N.CodPost in(select CodPost from post where CodUsua = '$CodUsua') and N.visto = 0 and N.CodUsua != '$CodUsua'");
		//$consulta->execute(array(
		//	':CodUsua' => $CodUsua
		//	));
		$resultados = $consulta->fetch_assoc();
		return $resultados;

	}

	function vistas($CodPost)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("update notificaciones set visto = 1 where CodPost = :CodPost");
		$consulta->execute(array(
			':CodPost' => $CodPost
			));
	}
}


class amigos
{
	function agregar($usua_enviador, $usua_receptor)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("insert into amigos(CodAm, usua_enviador, usua_receptor, status, solicitud) values(null, :usua_enviador, :usua_receptor, :status, :solicitud)");
		$consulta->execute(array(
							':usua_enviador' => $usua_enviador,
							':usua_receptor' => $usua_receptor,
							':status' => '',
							':solicitud' => 1

			));
	}

	function verificar($usua_enviador, $usua_receptor)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("select * from amigos where (usua_enviador = :usua_enviador and usua_receptor = :usua_receptor) or (usua_enviador = :usua_receptor and usua_receptor = :usua_enviador) ");
		$consulta->execute(array(
							':usua_enviador' => $usua_enviador,
							':usua_receptor' => $usua_receptor,
				

			));

		$resultados = $consulta->fetch_assoc();
		return $resultados;
	}

	function codigos_amigos($CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query(" select group_concat(usua_enviador,',', usua_receptor) as amigos from amigos where (usua_enviador = '$CodUsua' or usua_receptor = '$CodUsua') and status = 1 ");
		//$consulta->execute(array(
		//				':CodUsua' => $CodUsua
		//	));

      
		$resultados = $consulta->fetch_assoc();
		return $resultados;
	}


	function solicitudes($CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query(" select U.CodUsua, U.nombre, A.CodAm from usuarios U inner join amigos A on U.CodUsua = A.usua_enviador where A.usua_receptor = '$CodUsua' and A.status != 1");
		
		// esto no 
		//$consulta->execute(array(
		//				':CodUsua' => $CodUsua
		//	));

		$resultados = $consulta->fetch_assoc();
		return $resultados;
	}

	function aceptar($CodAm)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query(" update amigos set status = 1 where CodAm = :CodAm");
		$consulta->execute(array(
						':CodAm' => $CodAm
			));
	}

	function eliminar_solicitud($CodAm)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query("delete from amigos where CodAm = :CodAm");
		$consulta->execute(array(
						':CodAm' => $CodAm
			));
	}

	function cantidad_amigos($CodUsua)
	{
		$mysqli = new mysqli('127.0.0.1', 'root', '', 'social');
		$consulta = $mysqli->query(" select count(*) from amigos where (usua_enviador = '$CodUsua' or usua_receptor = '$CodUsua') and status = 1 ");
		//$consulta->execute(array(
						//':CodUsua' => $CodUsua
			//));

		$resultados = $consulta->fetch_assoc();
		return $resultados;
	}
}



 ?>