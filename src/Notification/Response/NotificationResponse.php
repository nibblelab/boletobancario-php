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
use BoletoFacil\Response\Response;

/**
 * Resposta da Notificação
 */
class NotificationResponse extends Response
{
    /**
     * Dados da resposta em caso de sucesso
     *
     * @var \BoletoFacil\Notification\Response\NotificationResponseData
     */
    private $data;
    
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
     * Obtêm a referência do pagamento
     * 
     * @return string|null
     */
    public function getPagtoReferencia(): ?string
    {
        return $this->data->getChargeReference();
    }
    
    /**
     * Obtêm o valor cobrado
     * 
     * @return float|null
     */
    public function getValorCobrado(): ?float
    {
        return $this->data->getChargeAmount();
    }
    
    /**
     * Obtêm o valor pago
     * 
     * @return float|null
     */
    public function getValorPago(): ?float
    {
        return $this->data->getAmount();
    }
    
    /**
     * Obtêm o valor das taxas
     * 
     * @return float|null
     */
    public function getValorTaxas(): ?float
    {
        return $this->data->getFee();
    }
    
    /**
     * Obtêm a data de vencimento do boleto ou parcela
     * 
     * @return \DateTime|null
     */
    public function getDataVencimento(): ?\DateTime
    {
        return $this->data->getChargeDueDate();
    }
    
    /**
     * Obtêm a data de pagamento do boleto ou parcela
     * 
     * @return \DateTime|null
     */
    public function getDataPagto(): ?\DateTime
    {
        return $this->data->getDate();
    }
    
    /**
     * Obtêm o código único de identificação da cobrança no Boleto Fácil
     * 
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->data->getChargeCode();
    }
}

