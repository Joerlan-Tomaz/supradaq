<?php

if (!defined('BASEPATH'))
    exit('Nenhum acesso de script direto permitido');

if (!function_exists('request_webservice_curl'))
{


    /**
     * Feita para realizar requisições.
     * @access public 
     * @author Rodolfo Romão <rodolforomao@gmail.com>
     * @version 0.1 
     * @copyright  GPL © 2021. 
     * @param $address: Endereço da requisição.
     * @param $body: Body a ser enviado caso seja diferente de GET.
     * @param $operationType: Tipo de operação "POST", "PUT", "GET", etc (Não obrigatório: "POST").
     * @param $header: array com todas as variáveis do header (Não obrigatório: array('Content-Type: application/json')).
     * @param $http_version: Versão do http que será usada (Não obrigatório: CURL_HTTP_VERSION_1_1).
     * @return Retorna o valor ou o erro.
     */
    function request_webservice_curl($address, $body, &$statusResponse = null, $operationType = "POST", $header = array('Content-Type: application/json'), $http_version = CURL_HTTP_VERSION_1_1)
    {
        $erroMsg = "Não há endereço.";
        $error = false;
        if (!empty($address))
        {
            if ($operationType != "GET")
            {
                if (empty($body))
                {
                    $error = true;
                    $erroMsg = "Body vazio.";
                }
            }

            if ($error == false)
            {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $address,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => $http_version,
                    CURLOPT_CUSTOMREQUEST => $operationType,
                    CURLOPT_POSTFIELDS => $body,
                    CURLOPT_HTTPHEADER => $header,
                ));
                $response_message = curl_exec($curl);
                $statusResponse = curl_getinfo($curl);
                curl_close($curl);
                return $response_message;
            }
        }
        return $erroMsg;
    }

}
