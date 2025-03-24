<?php
$enlace_conexion = new mysqli("localhost", "root", "", "cerberus_v2");

if ($enlace_conexion->errno) {
    echo $enlace_conexion->connect_error;
} else {
    echo "ok";
}