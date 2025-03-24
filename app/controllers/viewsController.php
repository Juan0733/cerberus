<?php

	namespace app\controllers; 
	use app\models\viewsModel;
	use app\models\mainModel;
	
	class viewsController extends viewsModel {

		/*---------- Controlador obtener vistas ----------*/
		public function obtenerVistasControlador($vista){
			if($vista!=""){
				$respuesta=$this->obtenerVistasModelo($vista);
			}else{
				$respuesta="login";
			}
			return $respuesta;
		}

		public function llamarMetodo(){
			$mainModel = new mainModel();
			$hola = $mainModel->contador();
			return $hola;
		}
		public function obtenerMenuUsuario($usuario){
			if ($usuario == 'JV' ) {
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
			}elseif ($usuario == 'SB') {

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
