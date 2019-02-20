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

use \BoletoFacil\Validation\ValidationDataConstants;
use \BoletoFacil\Validation\Validation;
use \BoletoFacil\Error\Errors;

/**
 * O que está sendo cobrado
 */
class PaymentItem extends Validation
{
    /**
     *
     * @var string
     */
    protected $description;
    /**
     *
     * @var string
     */
    protected $reference;
    /**
     *
     * @var float
     */
    protected $amount;
    /**
     *
     * @var string
     */
    protected $dueDate;
    /**
     *
     * @var int
     */
    protected $installments;
    /**
     *
     * @var int
     */
    protected $maxOverdueDays;
    /**
     *
     * @var float
     */
    protected $fine;
    /**
     *
     * @var float
     */
    protected $interest;
    /**
     *
     * @var float
     */
    protected $discountAmount;
    /**
     *
     * @var int
     */
    protected $discountDays;
    
    /**
     * Configuração da validação dos dados
     *
     * @var array 
     */
    protected $validation = array(
        'description' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 80, 'label' => 'Descrição', 'required' => true, 'min' => 0, 'max' => 0),
        'reference' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 255, 'label' => 'Referência', 'required' => false, 'min' => 0, 'max' => 0),
        'amount' => array('type' => ValidationDataConstants::IS_FLOAT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Valor', 'required' => true, 'min' => 2.30, 'max' => 0),
        'dueDate' => array('type' => ValidationDataConstants::IS_DATE, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Vencimento', 'required' => false, 'min' => 0, 'max' => 0),
        'installments' => array('type' => ValidationDataConstants::IS_INT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Parcelas', 'required' => false, 'min' => 1, 'max' => 24),
        'maxOverdueDays' => array('type' => ValidationDataConstants::IS_INT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Pagto. Atrasado', 'required' => false, 'min' => 0, 'max' => 29),
        'fine' => array('type' => ValidationDataConstants::IS_FLOAT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Multa', 'required' => false, 'min' => 0, 'max' => 20.00),
        'interest' => array('type' => ValidationDataConstants::IS_FLOAT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Juros', 'required' => false, 'min' => 0, 'max' => 20.00),
        'discountAmount' => array('type' => ValidationDataConstants::IS_FLOAT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Desconto', 'required' => false, 'min' => 0, 'max' => 0),
        'discountDays' => array('type' => ValidationDataConstants::IS_INT, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Dias Desconto', 'required' => false, 'min' => -1, 'max' => 0)
    );
    
    /**
     * Valores default
     *
     * @var array
     */
    private $defaults = array(
        'description' => '',
        'reference' => '',
        'amount' => 2.30,
        'dueDate' => '',
        'installments' => 1,
        'maxOverdueDays' => 0,
        'fine' => 0.00,
        'interest' => 0.00,
        'discountAmount' => 0.00,
        'discountDays' => -1
    );
    
    public function __construct()
    {
        $this->description = $this->defaults['description'];
        $this->reference = $this->defaults['reference'];
        $this->amount = $this->defaults['amount'];
        $this->dueDate = $this->defaults['dueDate'];
        $this->installments = $this->defaults['installments'];
        $this->maxOverdueDays = $this->defaults['maxOverdueDays'];
        $this->fine = $this->defaults['fine'];
        $this->interest = $this->defaults['interest'];
        $this->discountAmount = $this->defaults['discountAmount'];
        $this->discountDays = $this->defaults['discountDays'];
    }
    
    /**
     * Obtêm a descrição
     * 
     * @return string
     */
    public function getDescricao(): string
    {
        return $this->description;
    }
    
    /**
     * Seta a descrição
     * 
     * @param string $description
     * @return void
     */
    public function setDescricao($description): void
    {
        $this->description = $description;
    }

    /**
     * Obtêm a referência
     * 
     * @return string
     */
    public function getReferencia(): string
    {
        return $this->reference;
    }
    
    /**
     * Seta a referência
     * 
     * @param string $reference
     * @return void
     */
    public function setReferencia($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Obtêm o valor
     * 
     * @return float
     */
    public function getValor(): float
    {
        return $this->amount;
    }

    /**
     * Seta o valor
     * 
     * @param float $amount
     * @return void
     */
    public function setValor($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * Obtêm a data de vencimento
     * 
     * @return string
     */
    public function getDataVencimento(): string
    {
        return $this->dueDate;
    }
    
    /**
     * Seta a data de vencimento
     * 
     * @param string $dueDate
     * @return void
     */
    public function setDataVencimento($dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * Obtêm o número de parcelas
     * 
     * @return int
     */
    public function getParcelas(): int
    {
        return $this->installments;
    }

    /**
     * Seta o número de parcelas
     * 
     * @param int $installments
     * @return void
     */
    public function setParcelas($installments): void
    {
        $this->installments = $installments;
    }

    /**
     * Obtêm o número de dias em que o boleto pode ser pago em atraso
     * 
     * @return int
     */
    public function getDiasAtraso(): int
    {
        return $this->maxOverdueDays;
    }

    /**
     * Seta o número de dias em que o boleto pode ser pago em atraso
     * 
     * @param int $maxOverdueDays
     * @return void
     */
    public function setDiasAtraso($maxOverdueDays): void
    {
        $this->maxOverdueDays = $maxOverdueDays;
    }

    /**
     * Obtêm a multa
     * 
     * @return float
     */
    public function getMulta(): float
    {
        return $this->fine;
    }
    
    /**
     * Seta a multa
     * 
     * @param float $fine
     * @return void
     */
    public function setMulta($fine): void
    {
        $this->fine = $fine;
    }

    /**
     * Obtêm os juros
     * 
     * @return float
     */
    public function getJuros(): float
    {
        return $this->interest;
    }

    /**
     * Seta os juros
     * 
     * @param float $interest
     * @return void
     */
    public function setJuros($interest): void
    {
        $this->interest = $interest;
    }

    /**
     * Obtêm o valor do desconto
     * 
     * @return float
     */
    public function getDesconto(): float
    {
        return $this->discountAmount;
    }

    /**
     * Seta o valor do desconto
     * 
     * @param float $discountAmount
     * @return void
     */
    public function setDesconto($discountAmount): void
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * Obtêm a quantidade de dias para conceção do desconto
     * 
     * @return int
     */
    public function getDiasDesconto(): int
    {
        return $this->discountDays;
    }

    /**
     * Seta a quantidade de dias para conceção do desconto
     * 
     * @param type $discountDays
     * @return void
     */
    public function setDiasDesconto($discountDays): void
    {
        $this->discountDays = $discountDays;
    }

    /**
     * Valide os dados
     * 
     * @return void
     */
    public function validate(): void
    {
        $errs = array();
        if(!parent::isValid($errs)) {
            $err_str = '';
            foreach($errs as $e) {
                if(!empty($err_str)) {
                    $err_str .= ', ';
                }
                $err_str .= $e;
            }
            
            throw new \Exception("Erros foram encontrados na validação do pagamento: " . $err_str, Errors::VALIDATION_ERROR);
        }
    }
}

