<?php

include '../vendor/autoload.php'; 


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use app\models\mainModel;

class CargaMasiva extends mainModel{
    public function procesarArchivo($rutaArchivo)
    {
        $resultado = [];
        $conexion = $this->conectar(); // Usa el método conectar() definido en la clase Main

        if (!$conexion) {
            return [
                "exito" => false,
                "mensaje" => "No se pudo conectar a la base de datos."
            ];
        }

        $spreadsheet = IOFactory::load($rutaArchivo);
        $hoja = $spreadsheet->getActiveSheet();
        $datos = $hoja->toArray();

        // Validar encabezados
        $encabezados = ['Tipo de Documentos', 'Identificación', 'Nombres', 'Apellidos'];
        if ($datos[0] !== $encabezados) {
            return [
                "exito" => false,
                "mensaje" => "El archivo no tiene los encabezados esperados: " . implode(", ", $encabezados)
            ];
        }

        // Procesar filas
        foreach (array_slice($datos, 1) as $fila) {
            $tipoDocumento = $this->limpiarDato($fila[0]);
            $identificacion = $this->limpiarDato($fila[1]);
            $nombres = $this->limpiarDato($fila[2]);
            $apellidos = $this->limpiarDato($fila[3]);

            // Validar campos
            if (!$tipoDocumento || !$identificacion || !$nombres || !$apellidos) {
                $resultado[] = [
                    "estado" => "Error",
                    "mensaje" => "Campos incompletos en una fila",
                    "fila" => $fila
                ];
                continue;
            }

            // Insertar en la base de datos
            $query = "INSERT INTO agenda_personas (tipo_documento, num_identificacion, nombres, apellidos) 
                      VALUES ('$tipoDocumento', '$identificacion', '$nombres', '$apellidos')";
            if ($conexion->query($query)) {
                $resultado[] = [
                    "estado" => "Éxito",
                    "mensaje" => "Persona registrada correctamente",
                    "identificacion" => $identificacion
                ];
            } else {
                $resultado[] = [
                    "estado" => "Error",
                    "mensaje" => "Error al insertar en la base de datos: " . $conexion->error,
                    "identificacion" => $identificacion
                ];
            }
        }

        $conexion->close(); // Cierra la conexión con la base de datos

        return $resultado;
    }

    private function limpiarDato($dato)
    {
        return htmlspecialchars(trim($dato));
    }
}

// Verificar si se subió un archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['Formato_Agendas'])) {
    $archivo = $_FILES['Formato_Agendas'];

    // Validar tipo de archivo
    $ext = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    if ($ext !== 'xls' && $ext !== 'xlsx') {
        echo json_encode([
            "exito" => false,
            "mensaje" => "El archivo debe ser de tipo Excel (.xls, .xlsx)"
        ]);
        exit();
    }

    // Guardar el archivo en el servidor
    $rutaDestino = 'uploads/' . $archivo['name'];
    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        $cargaMasiva = new CargaMasiva(); // Instancia de la clase que hereda de Main
        $resultado = $cargaMasiva->procesarArchivo($rutaDestino);

        echo json_encode([
            "exito" => true,
            "resultado" => $resultado
        ]);
    } else {
        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al subir el archivo al servidor"
        ]);
    }
    exit();
}
