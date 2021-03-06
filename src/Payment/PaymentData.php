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

/**
 * Parte comum de informação de pagamento
 */
class PaymentData
{
    /**
     * Identificador único do pagamento no Boleto Fácil
     *
     * @var int 
     */
    protected $id;
    /**
     * Valor pago
     *
     * @var float
     */
    protected $amount;
    /**
     * Data do registro do pagamento na instituição financeira
     *
     * @var \DateTime
     */
    protected $date;
    /**
     * Taxa sobre o pagamento, em Reais.
     *
     * @var float
     */
    protected $fee;
    /**
     * Tipo de pagamento, podendo ser: BOLETO, CREDIT_CARD ou INSTALLMENT_CREDIT_CARD
     *
     * @var string 
     */
    protected $type;
    /**
     * Situação do pagamento, podendo ser: AUTHORIZED, DECLINED, FAILED, NOT_AUTHORIZED ou CONFIRMED
     *
     * @var string 
     */
    protected $status;
    
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
    public function setDate(\DateTime $date)
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
     * Obtêm o tipo de pagamento
     * 
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Seta o tipo de pagamento
     * 
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Obtêm a situação do pagamento
     * 
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Seta a situação do pagamento
     * 
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

}