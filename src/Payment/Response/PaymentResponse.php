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

namespace BoletoFacil\Payment\Response;

use \BoletoFacil\Payment\Response\PaymentResponseData;


/**
 * Resposta à requisição de pagamento 
 * 
 */
class PaymentResponse
{
    /**
     * Status da resposta
     *
     * @var bool 
     */
    private $success;
    /**
     * Mensagem de erro
     *
     * @var string 
     */
    private $errorMessage;
    /**
     * Dados da resposta em caso de sucesso
     *
     * @var \BoletoFacil\Payment\Response\PaymentResponseData
     */
    private $data;
    
    /**
     * Obtêm a flag de sucesso
     * 
     * @return bool
     */
    public function getSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Seta a flag de sucesso
     * 
     * @param type $success
     * @return void
     */
    public function setSuccess($success): void
    {
        $this->success = $success;
    }

    /**
     * Obtêm a mensagem de erro
     * 
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * Seta a mensagem de erro
     * 
     * @param type $errorMessage
     * @return void
     */
    public function setErrorMessage($errorMessage): void
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Obtêm os dados 
     * 
     * @return \BoletoFacil\Payment\Response\PaymentResponseData
     */
    public function getData(): \BoletoFacil\Payment\Response\PaymentResponseData
    {
        return $this->data;
    }

    /**
     * Seta os dados
     * 
     * @param \BoletoFacil\Payment\Response\PaymentResponseData $data
     * @return void
     */
    public function setData(\BoletoFacil\Payment\Response\PaymentResponseData $data): void
    {
        $this->data = $data;
    }

    
    /* Métodos para facilitar o uso dos dados de resposta do pagamento  */

    /**
     * Verifica se a requisição deu erro
     * 
     * @return bool
     */
    public function hasError(): bool
    {
        return !$this->success;
    }
    
    /**
     * Obtêm a mensagem de erro
     * 
     * @return string
     */
    public function getError(): string
    {
        return $this->errorMessage;
    }
    
    /**
     * Obtêm a url de checkout de um boleto
     * 
     * @return string|null
     * @throws \Exception
     */
    public function getCheckoutURLBoleto(): ?string
    {
        if(!$this->success) {
            throw new \Exception("A requisição não produziu resultados",Errors::REQUEST_ERROR);
        }
        
        $charges = $this->data->getCharges();
        if(count($charges) > 0)
        {
            return $charges[0]->getCheckoutUrl();
        }
        
        return null;
    }
    
    /**
     * Obtêm a lista de url's de checkout dos boletos de um carnê
     * 
     * @return array|null
     * @throws \Exception
     */
    public function getCheckoutURLsCarne(): ?array
    {
        if(!$this->success) {
            throw new \Exception("A requisição não produziu resultados",Errors::REQUEST_ERROR);
        }
        
        $charges = $this->data->getCharges();
        if(count($charges) > 0)
        {
            $urls = array();
            foreach($charges as $charge) {
                $urls[] = $charge->getCheckoutUrl();
            }
            return $urls;
        }
        
        return null;
    }
}

