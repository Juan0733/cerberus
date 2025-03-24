<?php
	
	namespace app\models;

	class viewsModel{

		/*---------- Modelo obtener vista ----------*/
		protected function obtenerVistasModelo($vista){
			if (isset($_SESSION['datos_usuario']['rol_usuario'])) {

				if ($_SESSION['datos_usuario']['rol_usuario'] == 'VI') {// --VIGILANTE--

					$listaBlanca=[
						"panel-principal",
						//INGRESO
						"ingreso",
						"ingreso-peatonal",
						"ingreso-vehicular",
						"panel-entrada",
						//VEHICULOS
						"registrar-vehiculo",
						"vigilante"];//VISTAS A LAS QUE PUEDE ACCEDER EL VIGILANTE

			  	}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'JV') {// --JEFE DE VIGILANTES--


					$listaBlanca=[ 
						"mensajero" , 
						"agendas",
						//VEHICULOS
						"registrar-vehiculo",
						"listar-vehiculos",
						"listado-vehiculos",
						//FUNCIONARIO
						"listado-funcionario",
						"registro-funcionario",
						//INGRESO
						"ingreso",
						"ingreso-peatonal",
						"ingreso-vehicular",
						"panel-entrada",
						"panel-salida",
						//NOVEDADES
						"novedades",
						//SALIDA
						"salida-peatonal",
						//VIGILANTES
						"vigilante",
						"lista-vigilantes",
						"editar-vigilante",
						"registro-agenda",
						"vigilante",
						"editar-funcionario",
						//VISITANTES
						"editar-visitante",					
						"nuevo-visitante-vs",
						"listado-visitantes",
						"panel-principal-jv",
						//APRENDIZ
						"listado-aprendiz",
						"registro-fichas",
						"registro-aprendiz",
						//INFORMES
						"informes",
						/* NOVEDADES */
						"listado-novedades"
						];//VISTAS A LAS QUE PUEDE ACCEDER EL JEFE DE VIGILANTE

				}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'CO') {// --COORDINADORA--

					$listaBlanca=[
						"panel-principal", 
						"mensajero", 
						//VIGILANTES
						"editar-vigilante",
						//FUNCIONARIO
						"registro-funcionario", 
						"listado-funcionario",
						"panel-principal-jv",
						"editar-funcionario",
						"vigilante",
						//APRENDIZ
						"listado-aprendiz",
						"editar-aprendiz",
						//VEHICULOS
						"listar-vehiculos",
						"listado-vehuculos"];//VISTAS A LAS QUE PUEDE ACCEDER EL COORDINADORA


				}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'SB') {// --SUBDIRECTOR--

					$listaBlanca=[
						"panel-principal-sb",  
						"mensajero",
						"informes",
						"agendas",
						//VIGILANTES
						"editar-vigilante",
						"lista-vigilantes",
						//VISITANTES						
						"nuevo-visitante",
						"panel-principal-jv",
						"listado-visitantes",
						//FUNCIONARIO 
						"registro-funcionario", 
						"listado-funcionario",
						"editar-funcionario",
						"registro-agenda",
						//VEHICULOS
						"listar-vehiculos",
						"listado-vehiculos",
						//APRENDIZ
						"listado-aprendiz",
						"editar-aprendiz"];//VISTAS A LAS QUE PUEDE ACCEDER EL SUBDIRECTOR

				}else {

					$listaBlanca=[
						"panel-principal",
						"nuevo-visitante-vs", 
						"listado-funcionario","registro-funcionario"];
				}
			}else {
				$listaBlanca=[
					"panel-principal",
					//VISITANTES
					"registro-visitante",
					"nuevo-visitante-vs",
					"editar-visitante-vs",
					//APRENDIZ
					"nuevo-aprendiz","vigilante","registro-funcionario",];
			}
			if(in_array($vista, $listaBlanca)){
				if(is_file("app/views/content/".$vista."-view.php")){
					$contenido="app/views/content/".$vista."-view.php";
				}else{
					$contenido="404";
				}
			}elseif($vista=="login" || $vista=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}

	}
