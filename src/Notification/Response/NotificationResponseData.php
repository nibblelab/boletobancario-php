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

/**
 * Dados da resposta da notificação
 */
class NotificationResponseData
{
    /**
     * Identificador único do pagamento no Boleto Fácil
     *
     * @var int 
     */
    private $id;
    /**
     * Valor pago
     *
     * @var float
     */
    private $amount;
    /**
     * Data do registro do pagamento na instituição financeira
     *
     * @var \DateTime
     */
    private $date;
    /**
     * Taxa sobre o pagamento, em Reais.
     *
     * @var float
     */
    private $fee;
    /**
     * Código único de identificação da cobrança no Boleto Fácil
     * 
     * @var int 
     */
    private $charge_code;
    /**
     * Valor cobrado
     *
     * @var float 
     */
    private $charge_amount;
    /**
     * Data de vencimento do boleto ou parcela
     *
     * @var \DateTime
     */
    private $charge_dueDate;
    /**
     * Código de referência da cobrança
     * 
     * @var string
     */
    private $charge_reference;
    
    /**
     * Obtêm o identificador único do pagamento no Boleto Fácil
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Seta o identificador único do pagamento no Boleto Fácil
     * 
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Obtêm o valor pago
     * 
     * @return float|null
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * Seta o valor pago
     * 
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    /**
     * 
     * Obtêm a data do registro do pagamento na instituição financeira
     * 
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * Seta a data do registro do pagamento na instituição financeira
     * 
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Obtêm a taxa sobre o pagamento, em Reais.
     * 
     * @return float|null
     */
    public function getFee(): ?float
    {
        return $this->fee;
    }

    /**
     * Seta a taxa sobre o pagamento, em Reais.
     * 
     * @param float $fee
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    }
    /**
     * Obtêm o código único de identificação da cobrança no Boleto Fácil
     * 
     * @return int|null
     */
    public function getChargeCode(): ?int
    {
        return $this->charge_code;
    }
    
    /**
     * Seta o código único de identificação da cobrança no Boleto Fácil
     * 
     * @param int $code
     * @return void
     */
    public function setChargeCode($code): void
    {
        $this->charge_code = $code;
    }
    
    /**
     * Obtêm o valor cobrado
     * 
     * @return float|null
     */
    public function getChargeAmount(): ?float
    {
        return $this->charge_amount;
    }

    /**
     * Seta o valor cobrado
     * 
     * @param float $amount
     */
    public function setChargeAmount($amount)
    {
        $this->charge_amount = $amount;
    }
    
    /**
     * Obtêm o código de referência da cobrança
     * 
     * @return string|null
     */
    public function getChargeReference(): ?string
    {
        return $this->charge_reference;
    }

    /**
     * Seta o código de referência da cobrança
     * 
     * @param string $reference
     * @return void
     */
    public function setChargeReference($reference): void
    {
        $this->charge_reference = $reference;
    }

    /**
     * Obtêm a data de vencimento do boleto ou parcela
     * 
     * @return \DateTime|null
     */
    public function getChargeDueDate(): ?\DateTime
    {
        return $this->charge_dueDate;
    }

    /**
     * Seta a data de vencimento do boleto ou parcela
     * 
     * @param \DateTime $dueDate
     * @return void
     */
    public function setChargeDueDate($dueDate): void
    {
        $this->charge_dueDate = $dueDate;
    }
}