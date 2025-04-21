<?php
	
namespace app\models;

class ViewModel{

	/*---------- Modelo obtener vista ----------*/
	public function obtenerVista($vista){

		$listaBlanca = [
			'login'
		];

		if (isset($_SESSION['datos_usuario'])) {

			if ($_SESSION['datos_usuario']['rol_usuario'] == 'JV') {// --JEFE DE VIGILANTES--
				$listaBlanca[] = "panel-principal";
			}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'VI') {// --VIGILANTE--


			}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'CO') {// --COORDINADORA--


			}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'SB') {// --SUBDIRECTOR--
				
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

	public function obtenerMenuUsuario(){
		if ($_SESSION['datos_usuario']['rol_usuario'] == 'JV' ) {
			$listMenu = [
				"INFORME" => [
						"TITULO" => 'Informe',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'informes/',
						"ICON" => 'analytics-outline'
				],
				"ENTRADA" => [
						"TITULO" => 'Entrada',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'panel-entrada/',
						"ICON" => 'enter-outline'
				],
				"SALIDA" => [
						"TITULO" => 'Salida',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'panel-salida/',
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
							"APRENDRIZ" => [
								"titulo" => 'Aprendiz',
								"url" => 'listado-aprendiz/',
								"icon" => 'person-outline'
							]
						]
				],
				"AGENDAS" => [
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
		}elseif ($_SESSION['datos_usuario']['rol_usuario'] == 'SB') {

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
