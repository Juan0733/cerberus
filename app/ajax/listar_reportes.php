<?php
namespace app\ajax;
use app\controllers\IngresoController as IngresoController;
require 'config/app.php';
require 'app/views/inc/session_start.php';
require 'autoload.php';
require 'app/controllers/ingresoController.php';

$insIngreso = new IngresoController();
echo $insIngreso->listarReportes("ENTRADA");    