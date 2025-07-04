<?php

   spl_autoload_register(function ($clase) {
    // Ruta base del proyecto (ajústala si es necesario)
        $baseDir = dirname(__DIR__) . '/'; // sube un nivel desde /controllers

        // Convertir namespace a ruta
        $archivo = $baseDir . str_replace('\\', '/', $clase) . '.php';

        if (is_file($archivo)) {
            require_once $archivo;
        } else {
            error_log("❌ Clase no encontrada: $archivo");
        }
    });