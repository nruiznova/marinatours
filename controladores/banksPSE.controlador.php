<?php

require_once __DIR__ . "/../extensiones/vendor/pse/vendor/autoload.php";

require_once __DIR__ . "/tokenPSE.controlador.php"; 
require_once __DIR__ . "/../modelos/bank.modelo.php";

use \PSEIntegration\PSEIntegration;
use \PSEIntegration\Models\GetBankListRequest;

class ControladorBanksPSE {
  static public function obtenerBancos() {
    $token = ControladorTokenPSE::obtenerToken();
    if($token && isset($token["access_token"])){
      $sdk = new PSEIntegration();
      $sdk->setCertificateIgnoreInvalid(true);
      $getBankListRequest = new GetBankListRequest('9012712671'); //entityCode
      $list = $sdk->getBankList($getBankListRequest, $token["access_token"]);
      if(!empty($list)) {
        // 1. Borrar listado anterior
        ModeloBanksPSE::borrarBancos();
        // 2. Insertar nuevos bancos
        foreach($list as $banco) {
          // $banco ahora es un array, no un objeto
          $codigo = $banco->financialInstitutionCode ?? null;
          $nombre = $banco->financialInstitutionName ?? null;

          if ($codigo && $nombre) {
            ModeloBanksPSE::insertarBanco($codigo, $nombre);
          }
        }

        return true;
      }
    }
    return false;
  }
}