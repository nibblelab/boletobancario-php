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

namespace BoletoFacil\Fetch;

use \BoletoFacil\Error\Errors;
use \BoletoFacil\Request\Request;
use \BoletoFacil\Request\HTTPMethod;
use \BoletoFacil\Fetch\FetchType;
use BoletoFacil\Fetch\Response\FetchResponse;
use BoletoFacil\Fetch\Response\FetchResponseData;
use BoletoFacil\Fetch\Response\Payment;

/**
 * Requisição de consulta de cobranças e pagamentos
 */
class FetchRequest extends Request
{
    /**
     * Processa a resposta da requisição
     * 
     * @param string $json_str string com o json de resposta
     * @return \BoletoFacil\Fetch\Response\FetchResponse
     * @throws \Exception
     */
    private function decodeResponse($json_str): \BoletoFacil\Fetch\Response\FetchResponse
    {
        $result_json = json_decode($json_str);
        if ($result_json === null && json_last_error() !== JSON_ERROR_NONE) {
            // erro ao decodificar 
            $json_except = new \Exception(json_last_error_msg(),json_last_error());
            throw new \Exception("O resultado da requisição não poderam ser interpretados",Errors::REQUEST_ERROR,$json_except);
        }
        
        // processe o retorno e gere os devidos objetos 
        $response = new FetchResponse();
        $response->setSuccess($result_json->success);
        
        if($result_json->success) {
            // deu certo. Processe o retorno
            $cobrancas = array();
            foreach($result_json->data->charges as $charge) {
                $response_data = new FetchResponseData();
                $response_data->setCode($charge->code);
                $dt_d = \DateTime::createFromFormat("d/m/Y", $charge->dueDate);
                $response_data->setDueDate($dt_d);
                $response_data->setLink($charge->link);
                $response_data->setInstallmentLink($charge->installmentLink);
                $response_data->setPayNumber($charge->payNumber);
                $pagamentos = array();
                foreach($charge->payments as $pay) {
                    $payment_data = new Payment();
                    $payment_data->setId($pay->id);
                    $payment_data->setAmount($pay->amount);
                    $dt_p = \DateTime::createFromFormat("d/m/Y", $pay->date);
                    $payment_data->setDate($dt_p);
                    $payment_data->setFee($pay->fee);
                    $payment_data->setType($pay->type);
                    $payment_data->setStatus($pay->status);
                    $pagamentos[] = $payment_data;
                }
                $response_data->setPayments($pagamentos);
                $cobrancas[] = $response_data;
            }
            $response->setData($cobrancas);
        }
        else {
            // deu errado
            $response->setErrorMessage($result_json->errorMessage);
        }
        
        return $response;
    }
    
    /**
     * Requisita uma lista de pagamentos à API
     * 
     * @param array $config dados de configuração
     * @param int $type parâmetro de busca
     * @param string $data_ini data inicial
     * @param string $data_end data final. Opcional
     * @return FetchResponse|null
     * @throws \BoletoFacil\Fetch\Exception
     */
    public function request(array $config, $type, $data_ini, $data_end = ''): ?\BoletoFacil\Fetch\Response\FetchResponse 
    {
        try {
            $data = array(
                'responseType' => $config['responseType']
            );
            if($type == FetchType::DATA_VENCIMENTO) {
                $data['beginDueDate'] = $data_ini;
                if(!empty($data_end)) {
                    $data['endDueDate'] = $data_end;
                }
            }
            else if($type == FetchType::DATA_PAGAMENTO) {
                $data['beginPaymentDate'] = $data_ini;
                if(!empty($data_end)) {
                    $data['endPaymentDate'] = $data_end;
                }
            }
            else if($type == FetchType::DATA_CONFIRMACAO) {
                $data['beginPaymentConfirmation'] = $data_ini;
                if(!empty($data_end)) {
                    $data['endPaymentConfirmation'] = $data_end;
                }
            }
            
            $result = $this->doRequest($config['url'] . 'list-charges', $data, HTTPMethod::GET);
            return $this->decodeResponse($result);
        } catch (Exception $ex) {
            throw  $ex;
        }
    }
}
