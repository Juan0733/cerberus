<?php

 /* -------------Nombre Sesion y APP---------------- */
 	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	const APP_NOMBRE = "Cerberus";

/*--------------Variables-------------------- */
	$urlBaseVariable = './';

/* -------------Zona Horaria----------------- */
	date_default_timezone_set("America/Bogota");

/* -------------Constantes------------------ */
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


