<?php

 /* -------------Nombre Sesion y APP---------------- */
	const APP_NOMBRE = "Cerberus";

/*--------------Variables-------------------- */
	$urlBaseVariable = './';

/* -------------Zona Horaria----------------- */
	date_default_timezone_set("America/Bogota");

/* -------------Constantes------------------ */
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

	const DIAS = [
		"Monday"    => "Lunes",
		"Tuesday"   => "Martes",
		"Wednesday" => "Miércoles",
		"Thursday"  => "Jueves",
		"Friday"    => "Viernes",
		"Saturday"  => "Sábado",
		"Sunday"    => "Domingo"
	];

	const MESES = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];


