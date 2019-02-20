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

namespace BoletoFacil\Payment;

use BoletoFacil\Error\Errors;
use BoletoFacil\Request\Request;
use BoletoFacil\Request\RequestHTTPMethod;
use BoletoFacil\Payment\PaymentItem;
use BoletoFacil\Payment\Payer;
use BoletoFacil\Payment\Response\PaymentResponse;
use BoletoFacil\Payment\Response\PaymentResponseData;
use BoletoFacil\Payment\Response\Charge;
use BoletoFacil\Payment\Response\Payment;

/**
 * Description of PaymentRequest
 *
 * @author johnatas
 */
class PaymentRequest extends Request
{
    /**
     * Processa a resposta da requisição
     * 
     * @param string $json_str string com o json de resposta
     * @return \BoletoFacil\Payment\Response\PaymentResponse|null
     * @throws \Exception
     */
    private function decodeResponse($json_str): ?\BoletoFacil\Payment\Response\PaymentResponse
    {
        $result_json = json_decode($json_str);
        if ($result_json === null && json_last_error() !== JSON_ERROR_NONE) {
            // erro ao decodificar 
            $json_except = new \Exception(json_last_error_msg(),json_last_error());
            throw new \Exception("O resultado da requisição não poderam ser interpretados",Errors::REQUEST_ERROR,$json_except);
        }
        
        // processe o retorno e gere os devidos objetos 
        
        $response = new PaymentResponse();
        $response->setSuccess($result_json->success);
        
        if($result_json->success) {
            // deu certo. Processe o retorno
            $response_data = new PaymentResponseData();
            if(property_exists($result_json->data, 'charges'))
            {
                // tem dados do que foi cobrado
                $charges = array();
                foreach($result_json->data->charges as $charge) {
                    $charge_obj = new Charge();
                    $charge_obj->setCode($charge->code);
                    $charge_obj->setReference($charge->reference);
                    $dt_c = \DateTime::createFromFormat("d/m/Y", $charge->dueDate);
                    $charge_obj->setDueDate($dt_c);
                    $charge_obj->setLink($charge->link);
                    $charge_obj->setCheckoutUrl($charge->checkoutUrl);
                    $charge_obj->setInstallmentLink($charge->installmentLink);
                    $charge_obj->setPayNumber($charge->payNumber);
                    $charges[] = $charge_obj;
                }
                $response_data->setCharges($charges);
            }
            if(property_exists($result_json->data, 'payments'))
            {
                // tem detalhes do pagamento
                $payments = array();
                foreach($result_json->data->payments as $payment) {
                    $payment_obj = new Payment();
                    $payment_obj->setId($payment->id);
                    $payment_obj->setAmount((float) $payment->amount);
                    $dt_p = \DateTime::createFromFormat("d/m/Y", $payment->date);
                    $payment_obj->setDate($dt_p);
                    $payment_obj->setFee((float) $payment->fee);
                    $payment_obj->setType($payment->type);
                    $payment_obj->setStatus($payment->status);
                    $payment_obj->setCreditCardId($payment->creditCardId);
                    $payments[] = $payment_obj;
                }
                $response_data->setPayments($payments);
            }
            
            $response->setData($response_data);
        }
        else {
            // deu errado
            $response->setErrorMessage($result_json->errorMessage);
        }
        
        return $response;
    }
    
    /**
     * requisita um pagamento à API
     * 
     * @param array $config dados de configuração do pagamento
     * @param \BoletoFacil\Payment\PaymentItem $item dados do pagamento
     * @param \BoletoFacil\Payment\Payer $pagador dados do pagador
     * @return PaymentResponse|null
     * @throws \BoletoFacil\Payment\Exception
     */
    public function request(array $config, \BoletoFacil\Payment\PaymentItem $item, \BoletoFacil\Payment\Payer $pagador): ?\BoletoFacil\Payment\Response\PaymentResponse
    {
        try {
            $data = array(
                'token' => $config['token'],
                'description' => $item->getDescricao(),
                'reference' => $item->getReferencia(),
                'amount' => $item->getValor(),
                'dueDate' => $item->getDataVencimento(),
                'installments' => $item->getParcelas(),
                'maxOverdueDays' => $item->getDiasAtraso(),
                'fine' => $item->getMulta(),
                'interest' => $item->getJuros(),
                'discountAmount' => $item->getDesconto(),
                'discountDays' => $item->getDiasDesconto(),
                'payerName' => $pagador->getNome(),
                'payerCpfCnpj' => $pagador->getCpfCnpj(),
                'payerEmail' => $pagador->getEmail(),
                'payerSecondaryEmail' => $pagador->getEmailSecundario(),
                'payerPhone' => $pagador->getTelefone(),
                'payerBirthDate' => $pagador->getDataDeNascimento(),
                'billingAddressStreet' => $pagador->getRua(),
                'billingAddressNumber' => $pagador->getNumero(),
                'billingAddressComplement' => $pagador->getComplemento(),
                'billingAddressNeighborhood' => $pagador->getBairro(),
                'billingAddressCity' => $pagador->getCidade(),
                'billingAddressState' => $pagador->getEstado(),
                'billingAddressPostcode' => $pagador->getCEP(),
                'notifyPayer' => $config['notifyPayer'],
                'notificationUrl' => $config['notificationUrl'],
                'responseType' => $config['responseType'],
                'paymentTypes' => $config['paymentTypes']
            );
            if(!empty($config['creditCardHash'])) {
                // checkout transparente de pagamento via cartão
                $data['creditCardHash'] = $config['creditCardHash'];
                $data['creditCardStore'] = $config['creditCardStore'];
                $data['creditCardId'] = $config['creditCardId'];
                $data['paymentAdvance'] = $config['paymentAdvance'];
            }
            
            $result = $this->doRequest($config['url'] . 'issue-charge', $data, RequestHTTPMethod::POST);
            return $this->decodeResponse($result);
        } catch (Exception $ex) {
            throw  $ex;
        }
    }
}

