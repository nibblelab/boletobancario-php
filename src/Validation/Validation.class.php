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

namespace BoletoFacil\Validation;

/**
 * Enumeração de constantes usadas na validação dos dados
 */
abstract class ValidationDataConstants
{
    /**
     * Tamanho do dado é desprezível
     */
    const IGNORE_LEN = 0;
    /**
     * Dado é inteiro
     */
    const IS_INT = 1;
    /**
     * Dado é float
     */
    const IS_FLOAT = 2;
    /**
     * Dado é string
     */
    const IS_STRING = 3;
    /**
     * Dado é uma data
     */
    const IS_DATE = 4;
    /**
     * Dado é cpf/cnpj
     */
    const IS_CPF_CNPJ = 5;
    /**
     * Dado é email
     */
    const IS_EMAIL = 6;
    /**
     * Dado é estado
     */
    const IS_UF = 7;
    /**
     * Dado é cep
     */
    const IS_CEP = 8;
}

/**
 * Validação de dados
 */
class Validation
{
    /**
     * regex de cpf/cnpj
     *
     * @var string 
     */
    private $cpf_cnpj_regex = '/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/';
    /**
     * regex de cep
     *
     * @var string 
     */
    private $cep_regex = '/([0-9]{2}[\.]?[0-9]{3}[-]?[0-9]{3})/';
    /**
     * regex de email
     *
     * @var string
     */
    private $email_regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
    /**
     * lista de estados
     *
     * @var array 
     */
    private $estados = array(
        "AC", "AL", "AM", "AP", "BA", "CE", "DF",
        "ES", "GO", "MA", "MG", "MS", "MT", "PA",
        "PB", "PE", "PI", "PR", "RJ", "RN", "RO", 
        "RR", "RS", "SC", "SE", "SP", "TO"
    );
    
    protected $validation = array();
    
    /**
     * Valida os dados
     * 
     * @param array $errs lista de erros
     * @return bool
     */
    protected function isValid(&$errs): bool
    {
        $errs = array();
        $is_valid = true;
        // itere sobre as variáveis do objeto
        $vars = get_object_vars($this);
        foreach($vars as $f => $value)
        {
            // veja se a variável atual não é que possui os dados de validação
            if($f != 'validation')
            {
                // veja se a variável atual possui configuração de validação
                if(isset($this->validation[$f])) {
                    $validation_data = $this->validation[$f];
                    $field = $validation_data['label'];
                    // veja se é obrigatório
                    if($validation_data['required'] && (is_null($value) || empty($value))) {
                        $errs[] = $field . ' é obrigatório!';
                        $is_valid = false;
                    }
                    else if(!$validation_data['required'] && (is_null($value) || empty($value))) {
                        // não é campo obrigatório e não foi informado. Ignore
                        continue;
                    }
                    else {
                        // realize as demais validações
                        if($validation_data['type'] == ValidationDataConstants::IS_STRING) {
                            // o tipo é uma string. Valide tamanho se possível
                            if($validation_data['size'] != 0 && strlen($value) > $validation_data['size']) {
                                $errs[] = $field . ' deve ter no máximo ' . $validation_data['size'] . ' caracteres';
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_INT) {
                            // tipo inteiro. Veja se contém um valor válido
                            if (ctype_digit(ltrim('' . $value, '-')) === false) {
                                $errs[] = $field . ' deve conter um número inteiro ';
                                $is_valid = false;
                            }
                            // veja se ele está abaixo do valor mínimo, caso este exista
                            if($validation_data['min'] != 0 && $value < $validation_data['min']) {
                                $errs[] = $field . ' deve ser maior do que ' . $validation_data['min'];
                                $is_valid = false;
                            }
                            // veja se ele está acima do valor máximo, caso este exista
                            if($validation_data['max'] != 0 && $value > $validation_data['max']) {
                                $errs[] = $field . ' deve ser menor do que ' . $validation_data['max'];
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_FLOAT) {
                            // tipo real. Veja se contém um valor válido
                            if (!is_numeric('' . $value)) {
                                $errs[] = $field . ' deve conter um número real ';
                                $is_valid = false;
                            }
                            // veja se ele está abaixo do valor mínimo, caso este exista
                            if($validation_data['min'] != 0.00 && $value < $validation_data['min']) {
                                $errs[] = $field . ' deve ser maior do que ' . $validation_data['min'];
                                $is_valid = false;
                            }
                            // veja se ele está acima do valor máximo, caso este exista
                            if($validation_data['max'] != 0.00 && $value > $validation_data['max']) {
                                $errs[] = $field . ' deve ser menor do que ' . $validation_data['max'];
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_DATE) {
                            // tipo data. Valide se é válida
                            unset($dt);
                            $dt = \DateTime::createFromFormat("d/m/Y", $value);
                            if($dt === false || array_sum($dt->getLastErrors()) > 0) {
                                $errs[] = $field . ' deve estar no formato DD/MM/YYYY ';
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_CPF_CNPJ) {
                            // tipo cpf/cnpj. Valide se está no formato permitido
                            if(preg_match($this->cpf_cnpj_regex, $value) !== 1) {
                                $errs[] = $field . ' deve ser um CPF/CNPJ válido, com ou sem pontuação ';
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_EMAIL) {
                            // tipo email. Valide se está no formato permitido
                            if(preg_match($this->email_regex, $value) !== 1) {
                                $errs[] = $field . ' deve ser um email válido ';
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_UF) {
                            // tipo estado. Veja se é válido
                            if(!in_array($value, $this->estados)) {
                                $errs[] = $field . ' deve ser um estado válido ';
                                $is_valid = false;
                            }
                        }
                        else if($validation_data['type'] == ValidationDataConstants::IS_CEP) {
                            // tipo cep. Valide se está no formato permitido
                            if(preg_match($this->cep_regex, $value) !== 1) {
                                $errs[] = $field . ' deve ser um CEP com ou sem pontuação ';
                                $is_valid = false;
                            }
                        }
                    }
                }
            }
        }
        
        return $is_valid;
    }
}

