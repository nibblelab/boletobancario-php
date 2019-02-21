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

namespace BoletoFacil\Fetch\Response;

use BoletoFacil\Fetch\Response\Payment;

/**
 * Dados da resposta da busca
 */
class FetchResponseData
{
    /**
     * Código único de identificação da cobrança no Boleto Fácil
     * 
     * @var int 
     */
    private $code;
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
     * Lista de pagamentos
     *
     * @var array 
     */
    private $payments;
    
    
    /**
     * Obtêm o código único de identificação da cobrança no Boleto Fácil
     * 
     * @return int
     */
    public function getCode(): int
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
     * Obtêm a data de vencimento do boleto ou parcela
     * 
     * @return \DateTime
     */
    public function getDueDate(): \DateTime
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
    
    /**
     * Obtêm a lista de pagamentos
     * 
     * @return array
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * Seta a lista de pagamentos
     * 
     * @param array $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

    
    /* métodos para facilitar o uso dos dados de pagamento */
    
    /**
     * Obtêm dados dos pagamentos realizados
     * 
     * @param int $index índice do pagamento na lista. Padrão = 0
     * @return Payment|null
     */
    public function dadosPagamento($index = 0): ?\BoletoFacil\Fetch\Response\Payment
    {
        if(count($this->payments) > 0)
        {
            return $this->payments[$index];
        }
        
        return null;
    }

    /**
     * Obtêm a lista de pagamentos
     * 
     * @return array
     */
    public function todosOsPagamentos(): array
    {
        return $this->payments;
    }
}