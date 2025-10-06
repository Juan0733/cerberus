<?php
namespace App\Models;

class ViewModel{

	public function obtenerVista($vista){
		$vistasExistentes = [
			"agendas",
			"acceso-denegado",
			"aprendices",
			"auto-registro-visitantes",
			"entradas",
			"funcionarios",
			"inicio",
			"informes-listado",
			"informes-grafica",
			"login",
			"novedades-usuario",
			"novedades-vehiculo",
			"sesion-expirada",
			"salidas",
			"vehiculos",
			"visitantes",
			"vigilantes",
			"permisos-usuario",
			"permisos-vehiculo"
		];

		if(in_array($vista, $vistasExistentes)){

			$vistasAccesibles = ['acceso-denegado', 'auto-registro-visitantes', 'login', 'sesion-expirada'];

			if(isset($_SESSION['datos_usuario'])){
				if ($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR') {
					$vistasAccesibles[] = 'inicio';
					$vistasAccesibles[] = 'entradas';
					$vistasAccesibles[] = 'salidas';
					$vistasAccesibles[] = 'aprendices';
					$vistasAccesibles[] = 'visitantes';
					$vistasAccesibles[] = 'vigilantes';
					$vistasAccesibles[] = 'funcionarios';
					$vistasAccesibles[] = 'informes-listado';
					$vistasAccesibles[] = 'agendas';
					$vistasAccesibles[] = 'vehiculos';
					$vistasAccesibles[] = 'novedades-usuario';
					$vistasAccesibles[] = 'novedades-vehiculo';
					$vistasAccesibles[] = 'permisos-usuario';
					$vistasAccesibles[] = 'permisos-vehiculo';

				}elseif ($_SESSION['datos_usuario']['rol'] == 'VIGILANTE') {
					$vistasAccesibles[] = 'inicio';
					$vistasAccesibles[] = 'entradas';
					$vistasAccesibles[] = 'salidas';
					$vistasAccesibles[] = 'aprendices';
					$vistasAccesibles[] = 'visitantes';
					$vistasAccesibles[] = 'vigilantes';
					$vistasAccesibles[] = 'funcionarios';
					$vistasAccesibles[] = 'agendas';
					$vistasAccesibles[] = 'vehiculos';
					$vistasAccesibles[] = 'permisos-usuario';

				}elseif ($_SESSION['datos_usuario']['rol'] == 'COORDINADOR') {
					$vistasAccesibles[] = 'inicio';
					$vistasAccesibles[] = 'aprendices';
					$vistasAccesibles[] = 'visitantes';
					$vistasAccesibles[] = 'vigilantes';
					$vistasAccesibles[] = 'funcionarios';
					$vistasAccesibles[] = 'agendas';
					$vistasAccesibles[] = 'permisos-usuario';

				}elseif ($_SESSION['datos_usuario']['rol'] == 'INSTRUCTOR') {
					$vistasAccesibles[] = 'inicio';
					$vistasAccesibles[] = 'aprendices';
					$vistasAccesibles[] = 'agendas';
					$vistasAccesibles[] = 'permisos-usuario';

				}elseif ($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR') {
					$vistasAccesibles[] = 'inicio';
					$vistasAccesibles[] = 'aprendices';
					$vistasAccesibles[] = 'visitantes';
					$vistasAccesibles[] = 'vigilantes';
					$vistasAccesibles[] = 'funcionarios';
					$vistasAccesibles[] = 'informes-listado';
					$vistasAccesibles[] = 'informes-grafica';
					$vistasAccesibles[] = 'agendas';
					$vistasAccesibles[] = 'vehiculos';
					$vistasAccesibles[] = 'novedades-usuario';
					$vistasAccesibles[] = 'novedades-vehiculo';
					$vistasAccesibles[] = 'permisos-usuario';
					$vistasAccesibles[] = 'permisos-vehiculo';
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

			if ($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' ) {
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
							"APRENDICES" => [
								"TITULO" => 'Aprendices',
								"URL" => 'aprendices',
								"ICON" => 'person-outline'
							],
							"VIGILANTES" => [
								"TITULO" => 'Vigilantes',
								"URL" => 'vigilantes',
								"ICON" => 'person-outline'
							],
							"FUNCIONARIOS" => [
								"TITULO" => 'Funcionarios',
								"URL" => 'funcionarios',
								"ICON" => 'person-outline'
							],
							"VISITANTES" => [
								"TITULO" => 'Visitantes',
								"URL" => 'visitantes',
								"ICON" => 'person-outline'
							]
							
						]
					],
					"VEHICULOS" => [
						"TITULO" => 'Vehículos',
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
						"ICON" => 'receipt-outline',
						"SUBMENU" => [
							"TABLA" => [
								"TITULO" => 'Listado',
								"URL" => 'informes-listado',
								"ICON" => 'clipboard-outline'
							]
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
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'megaphone-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'novedades-usuario',
								"ICON" => 'person-outline'
							],
							"VEHICULO" => [
								"TITULO" => 'Vehículo',
								"URL" => 'novedades-vehiculo',
								"ICON" => 'car-outline'
							]
						]
					],
					"PERMISOS" => [
						"TITULO" => 'Permisos',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'hand-right-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'permisos-usuario',
								"ICON" => 'person-outline'
							],
							"VEHICULO" => [
								"TITULO" => 'Vehículo',
								"URL" => 'permisos-vehiculo',
								"ICON" => 'car-outline'
							]
						]
					]

				];

			}elseif ($_SESSION['datos_usuario']['rol'] == 'VIGILANTE') {
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
							"APRENDICES" => [
								"TITULO" => 'Aprendices',
								"URL" => 'aprendices',
								"ICON" => 'person-outline'
							],
							"VIGILANTES" => [
								"TITULO" => 'Vigilantes',
								"URL" => 'vigilantes',
								"ICON" => 'person-outline'
							],
							"FUNCIONARIOS" => [
								"TITULO" => 'Funcionarios',
								"URL" => 'funcionarios',
								"ICON" => 'person-outline'
							],
							"VISITANTES" => [
								"TITULO" => 'Visitantes',
								"URL" => 'visitantes',
								"ICON" => 'person-outline'
							]
						]
					],
					"VEHICULOS" => [
						"TITULO" => 'Vehículos',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'vehiculos',
						"ICON" => 'car-outline',
					],
					"AGENDAS" => [
						"TITULO" => 'Agendas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'agendas',
						"ICON" => 'calendar-outline'
					],
					"PERMISOS" => [
						"TITULO" => 'Permisos',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'hand-right-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'permisos-usuario',
								"ICON" => 'person-outline'
							]
						]
					]
				];
				
			}elseif($_SESSION['datos_usuario']['rol'] == 'COORDINADOR') {
				$listMenu = [
					"INICIO" => [
						"TITULO" => 'Inicio',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'inicio',
						"ICON" => 'grid-outline'
					],
					"USUARIOS" => [
						"TITULO" => 'Usuarios',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'people-outline',
						"SUBMENU" => [
							"APRENDICES" => [
								"TITULO" => 'Aprendices',
								"URL" => 'aprendices',
								"ICON" => 'person-outline'
							],
							"VIGILANTES" => [
								"TITULO" => 'Vigilantes',
								"URL" => 'vigilantes',
								"ICON" => 'person-outline'
							],
							"FUNCIONARIOS" => [
								"TITULO" => 'Funcionarios',
								"URL" => 'funcionarios',
								"ICON" => 'person-outline'
							],
							"VISITANTES" => [
								"TITULO" => 'Visitantes',
								"URL" => 'visitantes',
								"ICON" => 'person-outline'
							]
						]
					],
					"AGENDAS" => [
						"TITULO" => 'Agendas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'agendas',
						"ICON" => 'calendar-outline'
					],
					"PERMISOS" => [
						"TITULO" => 'Permisos',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'hand-right-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'permisos-usuario',
								"ICON" => 'person-outline'
							]
						]
					]
				];

			}elseif($_SESSION['datos_usuario']['rol'] == 'INSTRUCTOR') {
				$listMenu = [
					"INICIO" => [
						"TITULO" => 'Inicio',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'inicio',
						"ICON" => 'grid-outline'
					],
					"USUARIOS" => [
						"TITULO" => 'Usuarios',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'people-outline',
						"SUBMENU" => [
							"APRENDICES" => [
								"TITULO" => 'Aprendices',
								"URL" => 'aprendices',
								"ICON" => 'person-outline'
							]
						]
					],
					"AGENDAS" => [
						"TITULO" => 'Agendas',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'agendas',
						"ICON" => 'calendar-outline'
					],
					"PERMISOS" => [
						"TITULO" => 'Permisos',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'hand-right-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'permisos-usuario',
								"ICON" => 'person-outline'
							]
						]
					]
				];

			}elseif($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'){
				$listMenu = [
					"INICIO" => [
						"TITULO" => 'Inicio',
						"CLASE" => '',
						"CLASE02" => '',
						"URL" => 'inicio',
						"ICON" => 'grid-outline'
					],
					"USUARIOS" => [
						"TITULO" => 'Usuarios',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'people-outline',
						"SUBMENU" => [
							"APRENDICES" => [
								"TITULO" => 'Aprendices',
								"URL" => 'aprendices',
								"ICON" => 'person-outline'
							],
							"VIGILANTES" => [
								"TITULO" => 'Vigilantes',
								"URL" => 'vigilantes',
								"ICON" => 'person-outline'
							],
							"FUNCIONARIOS" => [
								"TITULO" => 'Funcionarios',
								"URL" => 'funcionarios',
								"ICON" => 'person-outline'
							],
							"VISITANTES" => [
								"TITULO" => 'Visitantes',
								"URL" => 'visitantes',
								"ICON" => 'person-outline'
							]
						]
					],
					"VEHICULOS" => [
						"TITULO" => 'Vehículos',
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
						"ICON" => 'receipt-outline',
						"SUBMENU" => [
							"TABLA" => [
								"TITULO" => 'Listado',
								"URL" => 'informes-listado',
								"ICON" => 'clipboard-outline'
							],
							"GRAFICA" => [
								"TITULO" => 'Gráfica',
								"URL" => 'informes-grafica',
								"ICON" => 'analytics-outline'
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
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'megaphone-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'novedades-usuario',
								"ICON" => 'person-outline'
							],
							"VEHICULO" => [
								"TITULO" => 'Vehículo',
								"URL" => 'novedades-vehiculo',
								"ICON" => 'car-outline'
							]
						]
					],
					"PERMISOS" => [
						"TITULO" => 'Permisos',
						"CLASE" => 'sub-menu',
						"CLASE02" => 'sub-menu-link',
						"CLASE03" => 'sub-menu-list',
						"URL" => '#',
						"ICON" => 'hand-right-outline',
						"SUBMENU" => [
							"USUARIO" => [
								"TITULO" => 'Usuario',
								"URL" => 'permisos-usuario',
								"ICON" => 'person-outline'
							],
							"VEHICULO" => [
								"TITULO" => 'Vehículo',
								"URL" => 'permisos-vehiculo',
								"ICON" => 'car-outline'
							]
						]
					]
				];
			}

			return $listMenu;
		}
	}
}
