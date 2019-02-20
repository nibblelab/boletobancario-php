<?php
/**
 * 2019
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author    Nibblelab Tecnologia LTDA
 * @copyright 2019 Nibblelab Tecnologia LTDA
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */

namespace BoletoFacil\Request;

use \BoletoFacil\Error\Errors;
use \BoletoFacil\Request\HTTPMethod;

/**
 * Processamento de requisições na API
 */
class Request
{
    /**
     * Realiza uma requisição na API
     * 
     * @param string $url url destino da requisição
     * @param mixed $data array ou string com os dados.
     * @param int $http_method flag indicando o tipo de requisição HTTP a se realizada
     * @return string
     * @throws \Exception
     */
    protected function doRequest($url, $data, $http_method = HTTPMethod::POST): string
    {
        // verifique se a lib curl existe
        if(!function_exists('curl_init')) {
            throw new \Exception("A biblioteca CURL não está disponível em seu ambiente",Errors::CURL_NOT_FOUND);
        }
        
        // se é requisição POST é obrigatório passar dados
        if($http_method == HTTPMethod::POST && empty($data)) {
            throw new \Exception("Uma requisição POST não pode ser vazia",Errors::EMPTY_REQUEST);
        }
        
        // se está requisitando via get coloque os dada na url
        if($http_method == HTTPMethod::GET && !empty($data)) {
            if(is_array($data)) {
                // é array. Converta para http query
                $url .= '?' . http_build_query($data);
            }
            else {
                // converta para string e adicione a url
                $url .= '?' . $data;
            }
        }
        
        // abra o recurso
        $curl = curl_init($url);
        // obtenha o retorno
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // obrigue o uso de UTF-8
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        // sete a agent
        curl_setopt($curl, CURLOPT_USERAGENT, 'boletobancario-php');
        // defina o timeout da requisição
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        
        if($http_method == HTTPMethod::POST) {
            // se é post, configure o curl e envie os dados
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        
        // execute a requisição
        $result = curl_exec($curl);
        // feche o recurso
        curl_close($curl);
        
        // analise o retorno
        if($result !== false) {
            // deu certo. Retorne
            return $result;
        }
        else {
            // deu erro. Reporte
            $curl_except = new \Exception(curl_error($curl),curl_errno($curl));
            throw new \Exception("A requisição não pode ser atendida",Errors::CURL_ERROR, $curl_except);
        }
    }
}
