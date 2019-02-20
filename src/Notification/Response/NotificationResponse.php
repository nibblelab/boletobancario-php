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

namespace BoletoFacil\Notification\Response;

use BoletoFacil\Notification\Response\NotificationResponseData;

/**
 * Resposta da Notificação
 */
class NotificationResponse
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
     * @var \BoletoFacil\Notification\Response\NotificationResponseData
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
     * @return \BoletoFacil\Notification\Response\NotificationResponseData
     */
    public function getData(): \BoletoFacil\Notification\Response\NotificationResponseData
    {
        return $this->data;
    }

    /**
     * Seta os dados
     * 
     * @param \BoletoFacil\Notification\Response\NotificationResponseData $data
     * @return void
     */
    public function setData(\BoletoFacil\Notification\Response\NotificationResponseData $data): void
    {
        $this->data = $data;
    }

    
    /* Métodos para facilitar o uso dos dados de resposta da notificação */

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
     * Obtêm a referência do pagamento
     * 
     * @return string
     */
    public function getPagtoReferencia(): string
    {
        return $this->data->getChargeReference();
    }
    
    /**
     * Obtêm o valor cobrado
     * 
     * @return float
     */
    public function getValorCobrado(): float
    {
        return $this->data->getChargeAmount();
    }
    
    /**
     * Obtêm o valor pago
     * 
     * @return float
     */
    public function getValorPago(): float
    {
        return $this->data->getAmount();
    }
    
    /**
     * Obtêm o valor das taxas
     * 
     * @return float
     */
    public function getValorTaxas(): float
    {
        return $this->data->getFee();
    }
    
    /**
     * Obtêm a data de vencimento do boleto ou parcela
     * 
     * @return \DateTime
     */
    public function getDataVencimento(): \DateTime
    {
        return $this->data->getChargeDueDate();
    }
    
    /**
     * Obtêm a data de pagamento do boleto ou parcela
     * 
     * @return \DateTime
     */
    public function getDataPagto(): \DateTime
    {
        return $this->data->getDate();
    }
}

