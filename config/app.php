<?php

	const APP_URL_BASE = "../";
	const APP_URL_BASE_LOGIN = "";
	$URL_CONST = ""; 
	
	
	$APP_URL_BASE_VARIABLE = "../";


	
	const APP_NOMBRE = "Cerberus";
	const APP_SESSION_NAME = "POS";

	const TIPOS_DOCUMENTOS = [
		"TI" => 'Tarjeta de identidad',
		"CC" => 'Cedula de ciudadania',
		"PS" => 'Pasaporte',
		"OT" => 'Otro'
	];
	const TIPOS_VEHICULOS = [
		"AT" => 'Automovil',
		"BS" => 'Bus',
		"CM" => 'Camion',
		"MT" => 'Moto',
		"MC" => 'Moto Carro',
		"N/A" => 'No Aplica'
	];
	const TIPOS_ROL_USUARIO = [
		"FU" => 'Funcionario',
		"AP" => 'Aprendiz',
		"VI" => 'Vigilante',
		"CO" => 'Coordinador',
		"SB"=> 'Subdirector',
		"IE"=> 'Instructor',
		"AD"=> 'Administrativo',
		"OT"=> 'Otro',
		"VS" => 'Visitante'
	];

/*----------  Zona horaria  ----------*/
	date_default_timezone_set("America/Bogota");
