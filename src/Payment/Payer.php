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
 * Dados do pagador
 *
 */
class Payer extends Validation
{
    /**
     * Nome
     *
     * @var string 
     */
    protected $payerName;
    /**
     * CPF/CNPJ
     *
     * @var string 
     */
    protected $payerCpfCnpj;
    /**
     * Email primário
     *
     * @var string 
     */
    protected $payerEmail;
    /**
     * E-mail secundário
     *
     * @var string 
     */
    protected $payerSecondaryEmail;
    /**
     * Telefone
     *
     * @var string 
     */
    protected $payerPhone;
    /**
     * Data de nascimento
     *
     * @var string 
     */
    protected $payerBirthDate;
    /**
     * Endereço: Rua
     *
     * @var string 
     */
    protected $billingAddressStreet;
    /**
     * Endereço: número
     *
     * @var string 
     */
    protected $billingAddressNumber;
    /**
     * Endereço: complemento
     *
     * @var string 
     */
    protected $billingAddressComplement;
    /**
     * Endereço: bairro
     *
     * @var string 
     */
    protected $billingAddressNeighborhood;
    /**
     * Endereço: cidade
     *
     * @var string 
     */
    protected $billingAddressCity;
    /**
     * Endereço: estado
     *
     * @var string 
     */
    protected $billingAddressState;
    /**
     * Endereço: cep
     *
     * @var string 
     */
    protected $billingAddressPostcode;
    
    /**
     * Configuração da validação dos dados
     *
     * @var array 
     */
    protected $validation = array(
        'payerName' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 80, 'label' => 'Nome', 'required' => true, 'min' => 0, 'max' => 0),
        'payerCpfCnpj' => array('type' => ValidationDataConstants::IS_CPF_CNPJ, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'CPF/CNPJ', 'required' => true, 'min' => 0, 'max' => 0),
        'payerEmail' => array('type' => ValidationDataConstants::IS_EMAIL, 'size' => 80, 'label' => 'Email', 'required' => false, 'min' => 0, 'max' => 0),
        'payerSecondaryEmail' => array('type' => ValidationDataConstants::IS_EMAIL, 'size' => 80, 'label' => 'Email Secundário', 'required' => false, 'min' => 0, 'max' => 0),
        'payerPhone' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 25, 'label' => 'Telefone', 'required' => false, 'min' => 0, 'max' => 0),
        'payerBirthDate' => array('type' => ValidationDataConstants::IS_DATE, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Data de nascimento', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressStreet' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 100, 'label' => 'Rua', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressNumber' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 30, 'label' => 'Número', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressComplement' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 50, 'label' => 'Complemento', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressNeighborhood' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 50, 'label' => 'Bairro', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressCity' => array('type' => ValidationDataConstants::IS_STRING, 'size' => 60, 'label' => 'Cidade', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressState' => array('type' => ValidationDataConstants::IS_UF, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'Estado', 'required' => false, 'min' => 0, 'max' => 0),
        'billingAddressPostcode' => array('type' => ValidationDataConstants::IS_CEP, 'size' => ValidationDataConstants::IGNORE_LEN, 'label' => 'CEP', 'required' => false, 'min' => 0, 'max' => 0)
    );
    
    /**
     * Valores default
     *
     * @var array
     */
    private $defaults = array(
        'payerName' => '',
        'payerCpfCnpj' => '',
        'payerEmail' => '',
        'payerSecondaryEmail' => '',
        'payerPhone' => '',
        'payerBirthDate' => '',
        'billingAddressStreet' => '',
        'billingAddressNumber' => '',
        'billingAddressComplement' => '',
        'billingAddressNeighborhood' => '',
        'billingAddressCity' => '',
        'billingAddressState' => '',
        'billingAddressPostcode' => ''
    );
    
    public function __construct()
    {
        $this->payerName = $this->defaults['payerName'];
        $this->payerCpfCnpj = $this->defaults['payerCpfCnpj'];
        $this->payerEmail = $this->defaults['payerEmail'];
        $this->payerSecondaryEmail = $this->defaults['payerSecondaryEmail'];
        $this->payerPhone = $this->defaults['payerPhone'];
        $this->payerBirthDate = $this->defaults['payerBirthDate'];
        $this->billingAddressStreet = $this->defaults['billingAddressStreet'];
        $this->billingAddressNumber = $this->defaults['billingAddressNumber'];
        $this->billingAddressComplement = $this->defaults['billingAddressComplement'];
        $this->billingAddressNeighborhood = $this->defaults['billingAddressNeighborhood'];
        $this->billingAddressCity = $this->defaults['billingAddressCity'];
        $this->billingAddressState = $this->defaults['billingAddressState'];
        $this->billingAddressPostcode = $this->defaults['billingAddressPostcode'];
    }
    
    /**
     * Obtêm o nome
     * 
     * @return string
     */
    public function getNome(): string 
    { 
        return $this->payerName; 
    }
    
    /**
     * Seta o nome
     * 
     * @param string $nome
     * @return void
     */
    public function setNome($nome): void
    {
        $this->payerName = $nome;
    }
    
    /**
     * Obtêm o cpf/cnpj
     * 
     * @return string
     */
    public function getCpfCnpj(): string 
    { 
        return $this->payerCpfCnpj; 
    }
    
    /**
     * Seta o cpf/cnpj
     * 
     * @param string $cpf_cnpj
     * @return void
     */
    public function setCpfCnpj($cpf_cnpj): void
    {
        $this->payerCpfCnpj = $cpf_cnpj;
    }

    /**
     * Obtêm o email
     * 
     * @return string
     */
    public function getEmail(): string
    {
        return $this->payerEmail;
    }
    
    /**
     * Seta o email
     * 
     * @param string $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->payerEmail = $email;
    }

    /**
     * Obtêm o email secundário
     * 
     * @return string
     */
    public function getEmailSecundario(): string
    {
        return $this->payerSecondaryEmail;
    }
    
    /**
     * Seta o email secundário
     * 
     * @param string $email_secundario
     * @return void
     */
    function setEmailSecundario($email_secundario): void
    {
        $this->payerSecondaryEmail = $email_secundario;
    }

    /**
     * Obtêm o telefone
     * 
     * @return string
     */
    public function getTelefone(): string
    {
        return $this->payerPhone;
    }
    
    /**
     * Seta o telefone
     * 
     * @param string $telefone
     * @return void
     */
    public function setTelefone($telefone): void
    {
        $this->payerPhone = $telefone;
    }

    /**
     * Obtêm a data de nascimento
     * 
     * @return string
     */
    public function getDataDeNascimento(): string
    {
        return $this->payerBirthDate;
    }
    
    /**
     * Seta a data de nascimento
     * 
     * @param string $data_nascimento
     * @return void
     */
    public function setDataDeNascimento($data_nascimento): void
    {
        $this->payerBirthDate = $data_nascimento;
    }

    /**
     * Obtêm a rua
     * 
     * @return string
     */
    public function getRua(): string
    {
        return $this->billingAddressStreet;
    }
    
    /**
     * Seta a rua
     * 
     * @param string $rua
     * @return void
     */
    public function setRua($rua): void
    {
        $this->billingAddressStreet = $rua;
    }

    /**
     * Obtêm o número
     * 
     * @return string
     */
    public function getNumero(): string
    {
        return $this->billingAddressNumber;
    }
    
    /**
     * Obtêm o número
     * 
     * @param string $numero
     * @return void
     */
    public function setNumero($numero): void
    {
        $this->billingAddressNumber = $numero;
    }

    /**
     * Obtêm o complemento
     * 
     * @return string
     */
    public function getComplemento(): string
    {
        return $this->billingAddressComplement;
    }
    
    /**
     * Seta o complemento
     * 
     * @param string $complemento
     * @return void
     */
    public function setComplemento($complemento): void
    {
        $this->billingAddressComplement = $complemento;
    }

    /**
     * Obtêm o bairro
     * 
     * @return string
     */
    public function getBairro(): string
    {
        return $this->billingAddressNeighborhood;
    }
    
    /**
     * Seta o bairro
     * 
     * @param string $bairro
     * @return void
     */
    public function setBairro($bairro): void
    {
        $this->billingAddressNeighborhood = $bairro;
    }

    /**
     * Obtêm a cidade
     * 
     * @return string
     */
    public function getCidade(): string
    {
        return $this->billingAddressCity;
    }
    
    /**
     * Seta a cidade
     * 
     * @param string $cidade
     * @return void
     */
    public function setCidade($cidade): void
    {
        $this->billingAddressCity = $cidade;
    }

    /**
     * Obtêm o estado
     * 
     * @return string
     */
    public function getEstado(): string
    {
        return $this->billingAddressState;
    }
    
    /**
     * Seta o estado
     * 
     * @param string $estado
     * @return void
     */
    public function setEstado($estado): void
    {
        $this->billingAddressState = $estado;
    }

    /**
     * Obtêm o CEP
     * 
     * @return string
     */
    public function getCEP(): string
    {
        return $this->billingAddressPostcode;
    }

    /**
     * Seta o CEP
     * 
     * @param string $cep
     * @return void
     */
    public function setCEP($cep): void
    {
        $this->billingAddressPostcode = $cep;
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
            
            throw new \Exception("Erros foram encontrados na validação do pagador: " . $err_str, Errors::VALIDATION_ERROR);
        }
    }

}

