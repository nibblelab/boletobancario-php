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

namespace BoletoFacil;

use BoletoFacil\Error\Errors;
use BoletoFacil\Config\Config;
use BoletoFacil\Payment\PaymentRequest;
use BoletoFacil\Payment\PaymentItem;
use BoletoFacil\Payment\Payer;
use BoletoFacil\Payment\Response\PaymentResponse;

/**
 * Façade para uso da API do boleto fácil
 */
class BoletoFacil
{
    /**
     * Array de configuração
     *
     * @var array
     */
    private $config = array(
        'token' => '',
        'url' => '',
        'notifyPayer' => '',
        'notificationUrl' => '',
        'responseType' => Config::RESPONSE_TYPE,
        'paymentTypes' => '',
        'creditCardHash' => '',
        'creditCardStore' => false,
        'creditCardId' => '',
        'paymentAdvance' => false
    );
    /**
     * Dados do pagamento
     *
     * @var \BoletoFacil\Payment\PaymentItem
     */
    private $pagamento;
    /**
     * Dados do pagador
     *
     * @var \BoletoFacil\Payment\Payer
     */
    private $pagador;
    /**
     * Resposta da requisição de pagamento
     *
     * @var \BoletoFacil\Payment\Response\PaymentResponse 
     */
    private $response_payment;
    
    /**
     * 
     * @param string $token token do cliente
     * @param string $url_notificacao url que receberá as notificações do pagamento
     * @param bool $sandbox usa o modo sandbox ou não. Padrão = false
     */
    public function __construct($token, $url_notificacao, $sandbox = false)
    {
        $this->config['token'] = $token;
        if($sandbox) {
            $this->config['url'] = Config::SANDBOX_URL;
        }
        else {
            $this->config['url'] = Config::PRODUCTION_URL;
        }
        $this->config['notificationUrl'] = $url_notificacao;
    }
    
    /**
     * Executa a requisição de pagamento propriamente dita
     * 
     * @return PaymentResponse|null
     */
    private function execPayRequest(): ?\BoletoFacil\Payment\Response\PaymentResponse
    {
        $pay = new PaymentRequest();
        return $pay->request($this->config, $this->pagamento, $this->pagador);
    }
    
    /**
     * Gera o boleto para o pagamento e pagador enviados e retorna a url do checkout
     * 
     * @param \BoletoFacil\Payment\PaymentItem $pagamento dados do pagamento
     * @param \BoletoFacil\Payment\Payer $pagador dados do pagador
     * @return string|null
     * @throws \BoletoFacil\Exception
     * @throws \Exception
     */
    public function gerarBoleto(\BoletoFacil\Payment\PaymentItem $pagamento, \BoletoFacil\Payment\Payer $pagador): ?string
    {
        try
        {
            // valide os dados do pagamento
            $pagamento->validate();
            // valide os dados do pagador
            $pagador->validate();
            // configure o tipo de pagamento
            $this->config['paymentTypes'] = Config::PAYMENT_BOLETO;
            // monte os dados de execute a requisição
            $this->pagamento = $pagamento;
            $this->pagador = $pagador;
            $this->response_payment = $this->execPayRequest();
            if($this->response_payment->hasError()){
                throw new \Exception("O resultado não pode ser obtido: " . $this->response_payment->getError(),Errors::REQUEST_ERROR);
            }
            return $this->response_payment->getCheckoutURLBoleto();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Gera um carnê e retorna a lista dos url's dos boletos
     * 
     * @param \BoletoFacil\Payment\PaymentItem $pagamento dados do pagamento
     * @param \BoletoFacil\Payment\Payer $pagador dados do pagador
     * @return array|null
     * @throws \BoletoFacil\Exception
     * @throws \Exception
     */
    public function gerarCarne(\BoletoFacil\Payment\PaymentItem $pagamento, \BoletoFacil\Payment\Payer $pagador): ?array
    {
        try
        {
            if($pagamento->getParcelas() < 2) {
                // carnê precisa ter duas ou mais parcelas
                throw new \Exception("O carnê precisa ter duas ou mais parcelas",Errors::INCORRECT_REQUEST);
            }
            // valide os dados do pagamento
            $pagamento->validate();
            // valide os dados do pagador
            $pagador->validate();
            // configure o tipo de pagamento
            $this->config['paymentTypes'] = Config::PAYMENT_BOLETO;
            // monte os dados de execute a requisição
            $this->pagamento = $pagamento;
            $this->pagador = $pagador;
            $this->response_payment = $this->execPayRequest();
            if($this->response_payment->hasError()){
                throw new \Exception("O resultado não pode ser obtido: " . $this->response_payment->getError(),Errors::REQUEST_ERROR);
            }
            return $this->response_payment->getCheckoutURLsCarne();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Gera o pagamento em cartão
     * 
     * @param \BoletoFacil\Payment\PaymentItem $pagamento dados do pagamento
     * @param \BoletoFacil\Payment\Payer $pagador dados do pagador
     * @param bool $antecipar permitir ou não antecipação de parcelas. Padrão = false
     * @return string|null
     * @throws \BoletoFacil\Exception
     * @throws \Exception
     */
    public function gerarPagtoCartao(\BoletoFacil\Payment\PaymentItem $pagamento, \BoletoFacil\Payment\Payer $pagador, bool $antecipar = false): ?string
    {
        try
        {
            if($pagamento->getParcelas() > 12) {
                // cartão não pode parcelar em mais do que 12 vezes
                throw new \Exception("O parcelamento máximo para cartão de crédito é em 12 vezes",Errors::INCORRECT_REQUEST);
            }
            // valide os dados do pagamento
            $pagamento->validate();
            // valide os dados do pagador
            $pagador->validate();
            // configure o tipo de pagamento
            $this->config['paymentTypes'] = Config::PAYMENT_CREDIT_CARD;
            $this->config['paymentAdvance'] = $antecipar;
            // monte os dados de execute a requisição
            $this->pagamento = $pagamento;
            $this->pagador = $pagador;
            $this->response_payment = $this->execPayRequest();
            if($this->response_payment->hasError()){
                throw new \Exception("O resultado não pode ser obtido: " . $this->response_payment->getError(),Errors::REQUEST_ERROR);
            }
            return $this->response_payment->getCheckoutURLBoleto();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * Gerar pagamento em boleto e/ou cartão
     * 
     * @param \BoletoFacil\Payment\PaymentItem $pagamento dados do pagamento
     * @param \BoletoFacil\Payment\Payer $pagador dados do pagador
     * @param bool $antecipar permitir ou não antecipação de parcelas. Padrão = false
     * @return string|null
     * @throws \BoletoFacil\Exception
     * @throws \Exception
     */
    public function gerarBoletoOuCartao(\BoletoFacil\Payment\PaymentItem $pagamento, \BoletoFacil\Payment\Payer $pagador, bool $antecipar = false): ?string 
    {
        try
        {
            if($pagamento->getParcelas() > 12) {
                // cartão não pode parcelar em mais do que 12 vezes
                throw new \Exception("O parcelamento máximo para cartão de crédito é em 12 vezes",Errors::INCORRECT_REQUEST);
            }
            // valide os dados do pagamento
            $pagamento->validate();
            // valide os dados do pagador
            $pagador->validate();
            // configure o tipo de pagamento
            $this->config['paymentTypes'] = Config::PAYMENT_ALL;
            $this->config['paymentAdvance'] = $antecipar;
            // monte os dados de execute a requisição
            $this->pagamento = $pagamento;
            $this->pagador = $pagador;
            $this->response_payment = $this->execPayRequest();
            if($this->response_payment->hasError()){
                throw new \Exception("O resultado não pode ser obtido",Errors::REQUEST_ERROR);
            }
            return $this->response_payment->getCheckoutURLBoleto();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    
    /**
     * gera pagamento transparente em cartão de crédito
     * 
     * @param \BoletoFacil\Payment\PaymentItem $pagamento dados do pagamento
     * @param \BoletoFacil\Payment\Payer $pagador dados do pagador
     * @param string $hash_cartao hash do cartão
     * @param string $id_cartao id do cartão, caso já o tenha armazenado antes. Opcional
     * @param bool $armazenar_cartao flag para indicar se o cartão deve ser armazenado um id gerado para ele. Padrão = false
     * @param bool $antecipar permitir ou não antecipação de parcelas. Padrão = false
     * @return void
     * @throws \BoletoFacil\Exception
     * @throws \Exception
     */
    public function gerarPagtoCartaoTransparente(\BoletoFacil\Payment\PaymentItem $pagamento, 
            \BoletoFacil\Payment\Payer $pagador, string $hash_cartao, string $id_cartao, 
            bool $armazenar_cartao = false, bool $antecipar = false): void
    {
        try
        {
            if($pagamento->getParcelas() > 12) {
                // cartão não pode parcelar em mais do que 12 vezes
                throw new \Exception("O parcelamento máximo para cartão de crédito é em 12 vezes",Errors::INCORRECT_REQUEST);
            }
            if(empty($hash_cartao)) {
                // hash do cartão é obrigatório aqui
                throw new \Exception("O hash do cartão é obrigatório",Errors::INCORRECT_REQUEST);
            }
            // valide os dados do pagamento
            $pagamento->validate();
            // valide os dados do pagador
            $pagador->validate();
            // configure o tipo de pagamento
            $this->config['paymentTypes'] = Config::PAYMENT_CREDIT_CARD;
            $this->config['paymentAdvance'] = $antecipar;
            $this->config['creditCardStore'] = $armazenar_cartao;
            $this->config['creditCardId'] = $id_cartao;
            $this->config['creditCardHash'] = $hash_cartao;
            // monte os dados de execute a requisição
            $this->pagamento = $pagamento;
            $this->pagador = $pagador;
            $this->response_payment = $this->execPayRequest();
            if($this->response_payment->hasError()){
                throw new \Exception("O resultado não pode ser obtido",Errors::REQUEST_ERROR);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }
        
}


