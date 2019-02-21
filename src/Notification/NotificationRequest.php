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

namespace BoletoFacil\Notification;

use \BoletoFacil\Error\Errors;
use \BoletoFacil\Request\Request;
use \BoletoFacil\Request\HTTPMethod;
use \BoletoFacil\Notification\Response\NotificationResponse;
use \BoletoFacil\Notification\Response\NotificationResponseData;

/**
 * Requisição de notificação de pagamento
 */
class NotificationRequest extends Request
{
    /**
     * Processa a resposta da requisição
     * 
     * @param string $json_str string com o json de resposta
     * @return \BoletoFacil\Notification\Response\NotificationResponse
     * @throws \Exception
     */
    private function decodeResponse($json_str): \BoletoFacil\Notification\Response\NotificationResponse
    {
        $result_json = json_decode($json_str);
        if ($result_json === null && json_last_error() !== JSON_ERROR_NONE) {
            // erro ao decodificar 
            $json_except = new \Exception(json_last_error_msg(),json_last_error());
            throw new \Exception("O resultado da requisição não poderam ser interpretados",Errors::REQUEST_ERROR,$json_except);
        }
        
        // processe o retorno e gere os devidos objetos 
        $response = new NotificationResponse();
        $response->setSuccess($result_json->success);
        
        if($result_json->success) {
            // deu certo. Processe o retorno
            $response_data = new NotificationResponseData();
            $response_data->setId($result_json->data->payment->id);
            $response_data->setAmount($result_json->data->payment->amount);
            $dt_d = \DateTime::createFromFormat("d/m/Y", $result_json->data->payment->date);
            $response_data->setDate($dt_d);
            $response_data->setFee($result_json->data->payment->fee);
            $response_data->setChargeAmount($result_json->data->payment->charge->amount);
            $response_data->setChargeCode($result_json->data->payment->charge->code);
            $dt_v = \DateTime::createFromFormat("d/m/Y", $result_json->data->payment->charge->dueDate);
            $response_data->setChargeDueDate($dt_v);
            $response_data->setChargeReference($result_json->data->payment->charge->reference);
            $response->setData($response_data);
        }
        else {
            // deu errado
            $response->setErrorMessage($result_json->errorMessage);
        }
        
        return $response;
    }
    
    /**
     * requisita detalhes de um pagamento à API
     * 
     * @param array $config dados de configuração 
     * @return \BoletoFacil\Notification\Response\NotificationResponse|null
     * @throws \BoletoFacil\Notification\Exception
     */
    public function request(array $config): ?\BoletoFacil\Notification\Response\NotificationResponse 
    {
        try {
            $data = array(
                'paymentToken' => $config['paymentToken'],
                'responseType' => $config['responseType']
            );
            
            $result = $this->doRequest($config['url'] . 'fetch-payment-details', $data, HTTPMethod::GET);
            return $this->decodeResponse($result);
        } catch (Exception $ex) {
            throw  $ex;
        }
    }
}
