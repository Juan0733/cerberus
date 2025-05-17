<?php
	
namespace app\models;

class ViewModel{

	/*---------- Modelo obtener vista ----------*/
	public function obtenerVista($vista){

		$listaBlanca = [
			'login'
		];

		if (isset($_SESSION['datos_usuario'])) {

			if ($_SESSION['datos_usuario']['rol'] == 'jefe vigilantes') {// --JEFE DE VIGILANTES--
				$listaBlanca[] = "inicio";
				$listaBlanca[] = "entradas";
				$listaBlanca[] = "salidas";
			}elseif ($_SESSION['datos_usuario']['rol'] == 'vigilante raso') {// --VIGILANTE--


			}elseif ($_SESSION['datos_usuario']['rol'] == 'bienestar aprendiz') {// --BIENESTAR APRENDIZ--


			}elseif ($_SESSION['datos_usuario']['rol'] == 'coordinador') {// --COORDINADORA--


			}elseif ($_SESSION['datos_usuario']['rol'] == 'subdirector') {// --SUBDIRECTOR--
				
			}
		}

		if(in_array($vista, $listaBlanca)){
			$contenido = "app/views/content/".$vista."-view.php";
		}elseif($vista=="index"){
			$contenido = "app/views/content/login-view.php";
		}else{
			$contenido = "app/views/content/404-view.php";
		}

		return $contenido;
	}

	public function obtenerMenuOpciones(){
		if ($_SESSION['datos_usuario']['rol'] == 'jefe vigilantes' ) {
			$listMenu = [
				"INICIO" => [
						"TITULO" => 'Inicio',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'inicio/',
						"ICON" => 'grid-outline'
				],
				"ENTRADA" => [
						"TITULO" => 'Entradas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'entradas/',
						"ICON" => 'enter-outline'
				],
				"SALIDA" => [
						"TITULO" => 'Salidas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'salidas/',
						"ICON" => 'exit-outline'
				],
				"SUBMENU" => [
						"TITULO" => 'Usuarios',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'people-outline',
						"OPC" => [
							"APRENDRIZ" => [
								"titulo" => 'Aprendices',
								"url" => 'aprendices/',
								"icon" => 'person-outline'
							],
							"FUNCIONARIO" => [
								"titulo" => 'Funcionarios',
								"url" => 'funcionarios/',
								"icon" => 'person-outline'
							],
							"VISITANTES" => [
								"titulo" => 'Visitantes',
								"url" => 'visitante/',
								"icon" => 'person-outline'
							],
							"VIGILANTES" => [
								"titulo" => 'Vigilantes',
								"clase" => 'sub-item',
								"url" => 'vigilantes/',
								"icon" => 'person-outline'
							]
						]
				],
				"VEHICULOS" => [
						"TITULO" => 'Vehiculos',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'vehiculos/',
						"ICON" => 'car-outline'
				],
				"INFORME" => [
						"TITULO" => 'Informes',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'informes/',
						"ICON" => 'analytics-outline'
				],
				"AGENDAS" => [
					"TITULO" => 'Agendas',
					"CLASE" => '',
					"CLASE02" => '',
					"URL" => 'agendas/',
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

			$listMenu = [
				"INFORME" => [
						"TITULO" => 'Informe',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'informes/',
						"ICON" => 'analytics-outline'

				],
				
				"SUBMENU" => [
						"TITULO" => 'Usuarios',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'people-outline',
						"OPC" => [
							"VIGILANTES" => [
								"titulo" => 'Vigilantes',
								"clase" => 'sub-item',
								"url" => 'lista-vigilantes/',
								"icon" => 'person-outline'
							],
							"VISITANTES" => [
								"titulo" => 'Visitantes',
								"url" => 'listado-visitantes/',
								"icon" => 'person-outline'
							],
							"FUNCIONARIO" => [
								"titulo" => 'Funcionario',
								"url" => 'listado-funcionario/',
								"icon" => 'person-outline'
							],
							
						]
				],"AGENDAS" => [
					"TITULO" => 'Agendas',
					"CLASE" => '',
					"CLASE02" => '',
					"URL" => 'agendas/',
					"ICON" => 'person-outline'
				],
				"VEHICULOS" => [
						"TITULO" => 'Vehiculos',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'listado-vehiculos/',
						"ICON" => 'car-outline'
				],
				"NOVEDADES" => [
						"TITULO" => 'Novedades',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'listado-novedades/',
						"ICON" => 'receipt-outline'
				]
			];
		} else {
			$listMenu = [
				"INFORME" => [
						"TITULO" => 'Informe',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'informes/',
						"ICON" => 'analytics-outline'
				],
			];
		}
		return $listMenu;
	}
}
