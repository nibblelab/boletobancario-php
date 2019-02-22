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


/**
 * Dados do que foi cobrado
 */
class Charge
{
    /**
     * Código único de identificação da cobrança no Boleto Fácil
     * 
     * @var int 
     */
    private $code;
    /**
     * Código de referência da cobrança
     * 
     * @var string
     */
    private $reference;
    /**
     * Data de vencimento do boleto ou parcela
     *
     * @var \DateTime
     */
    private $dueDate;
    /**
     * Link para visualização/download do boleto ou carnê
     *
     * @var string
     */
    private $link;
    /**
     * Link da página de checkout da cobrança
     *
     * @var string
     */
    private $checkoutUrl;
    /**
     * Link para visualização/download do boleto (somente a parcela)
     *
     * @var string
     */
    private $installmentLink;
    /**
     * Linha digitável para pagamento online
     *
     * @var string
     */
    private $payNumber;
    
    /**
     * Obtêm o código único de identificação da cobrança no Boleto Fácil
     * 
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }
    
    /**
     * Seta o código único de identificação da cobrança no Boleto Fácil
     * 
     * @param int $code
     * @return void
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * Obtêm o código de referência da cobrança
     * 
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Seta o código de referência da cobrança
     * 
     * @param string $reference
     * @return void
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Obtêm a data de vencimento do boleto ou parcela
     * 
     * @return \DateTime|null
     */
    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    /**
     * Seta a data de vencimento do boleto ou parcela
     * 
     * @param \DateTime $dueDate
     * @return void
     */
    public function setDueDate($dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Obtêm o link para visualização/download do boleto ou carnê
     * 
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * Seta o link para visualização/download do boleto ou carnê
     * 
     * @param string $link
     * @return void
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * Obtêm o link da página de checkout da cobrança
     * 
     * @return string|null
     */
    public function getCheckoutUrl(): ?string
    {
        return $this->checkoutUrl;
    }

    /**
     * Seta o link da página de checkout da cobrança
     * 
     * @param string $checkoutUrl
     * @return void
     */
    public function setCheckoutUrl($checkoutUrl): void
    {
        $this->checkoutUrl = $checkoutUrl;
    }

    /**
     * Obtêm o link para visualização/download do boleto (em caso de parcelamento)
     * 
     * @return string|null
     */
    public function getInstallmentLink(): ?string
    {
        return $this->installmentLink;
    }

    /**
     * Seta o link para visualização/download do boleto (em caso de parcelamento)
     * 
     * @param string $installmentLink
     * @return void
     */
    public function setInstallmentLink($installmentLink): void
    {
        $this->installmentLink = $installmentLink;
    }

    /**
     * Obtêm a linha digitável para pagamento online
     * 
     * @return string|null
     */
    public function getPayNumber(): ?string
    {
        return $this->payNumber;
    }

    /**
     * Seta a linha digitável para pagamento online
     * 
     * @param string $payNumber
     * @return void
     */
    public function setPayNumber($payNumber): void
    {
        $this->payNumber = $payNumber;
    }

}

