<?php
namespace App\Services;

class FichaService extends MainService{

    public function sanitizarParametros(){
        $parametros = [];

        if(isset($_GET['ficha'])){
            $numeroFicha = $this->limpiarDatos($_GET['ficha']);
            unset($_GET['ficha']);

            if(preg_match('/^[0-9]{7}$/', $numeroFicha)){
                $parametros['numero_ficha'] = $numeroFicha;
            }
        }

        return [
            'tipo' => 'OK',
            'parametros' => $parametros
        ];
    }
}
    