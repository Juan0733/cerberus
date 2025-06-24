<?php
	
namespace app\models;

class ViewModel{

	/*---------- Modelo obtener vista ----------*/
	public function obtenerVista($vista){
		$vistasExistentes = [
			"login",
			"sesion-expirada",
			"acceso-denegado",
			"inicio",
			"entradas",
			"salidas",
			"aprendices",
			"visitantes",
			"vigilantes",
			"funcionarios",
			"informes-listado",
			"informes-grafica",
			"agendas",
			"vehiculos",
			"auto-registro-visitantes"
		];

		if(in_array($vista, $vistasExistentes)){

			$vistasAccesibles = ['login', 'sesion-expirada', 'acceso-denegado', 'auto-registro-visitantes'];

			if(isset($_SESSION['datos_usuario'])){
				if ($_SESSION['datos_usuario']['rol'] == 'jefe vigilantes') {// --JEFE DE VIGILANTES--
					$vistasAccesibles[] = 'inicio';
					$vistasAccesibles[] = 'entradas';
					$vistasAccesibles[] = 'salidas';
					$vistasAccesibles[] = 'aprendices';
					$vistasAccesibles[] = 'visitantes';
					$vistasAccesibles[] = 'vigilantes';
					$vistasAccesibles[] = 'funcionarios';
					$vistasAccesibles[] = 'informes-listado';
					$vistasAccesibles[] = 'informes-grafica';
					$vistasAccesibles[] = 'agendas';
					$vistasAccesibles[] = 'vehiculos';

				}elseif ($_SESSION['datos_usuario']['rol'] == 'vigilante raso') {// --VIGILANTE--


				}elseif ($_SESSION['datos_usuario']['rol'] == 'coordinador') {// --COORDINADORA--


				}elseif ($_SESSION['datos_usuario']['rol'] == 'subdirector') {// --SUBDIRECTOR--
					
				}
			}
			
			if(in_array($vista, $vistasAccesibles)){
				$contenido = "app/views/content/".$vista."-view.php";

			}else{
				$contenido = "app/views/content/acceso-denegado-view.php";
			}

		}else{
			$contenido = "app/views/content/404-view.php";
		}

		return $contenido;
	}

	public function obtenerMenuOpciones(){
		if(isset($_SESSION['datos_usuario'])){
			if ($_SESSION['datos_usuario']['rol'] == 'jefe vigilantes' ) {
				$listMenu = [
					"INICIO" => [
						"TITULO" => 'Inicio',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'inicio',
						"ICON" => 'grid-outline'
					],
					"ENTRADAS" => [
						"TITULO" => 'Entradas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'entradas',
						"ICON" => 'enter-outline'
					],
					"SALIDAS" => [
						"TITULO" => 'Salidas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'salidas',
						"ICON" => 'exit-outline'
					],
					"USUARIOS" => [
						"TITULO" => 'Usuarios',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'people-outline',
						"SUBMENU" => [
							"APRENDRIZ" => [
								"TITULO" => 'Aprendices',
								"URL" => 'aprendices',
								"ICON" => 'person-outline'
							],
							"FUNCIONARIO" => [
								"TITULO" => 'Funcionarios',
								"URL" => 'funcionarios',
								"ICON" => 'person-outline'
							],
							"VISITANTES" => [
								"TITULO" => 'Visitantes',
								"URL" => 'visitantes',
								"ICON" => 'person-outline'
							],
							"VIGILANTES" => [
								"TITULO" => 'Vigilantes',
								"URL" => 'vigilantes',
								"ICON" => 'person-outline'
							]
						]
					],
					"VEHICULOS" => [
						"TITULO" => 'Vehiculos',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'vehiculos',
						"ICON" => 'car-outline',
					],
					"INFORMES" => [
						"TITULO" => 'Informes',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'analytics-outline',
						"SUBMENU" => [
							"TABLA" => [
								"TITULO" => 'Listado',
								"URL" => 'informes-listado',
								"ICON" => 'person-outline'
							],
							"GRAFICA" => [
								"TITULO" => 'Gráfica',
								"URL" => 'informes-grafica',
								"ICON" => 'person-outline'
							],
						]
					],
					"AGENDAS" => [
						"TITULO" => 'Agendas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'agendas',
						"ICON" => 'calendar-outline'
					],
					"NOVEDADES" => [
						"TITULO" => 'Novedades',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'listado-novedades',
						"ICON" => 'receipt-outline'
					]
				];
			}elseif ($_SESSION['datos_usuario']['rol'] == 'subdirector' ) {

			} else {
			}

			return $listMenu;
		}
	}
}
