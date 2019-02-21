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

namespace BoletoFacil\Response;


/**
 * Parte comum das respostas de requisições
 */
class Response
{
    /**
     * Status da resposta
     *
     * @var bool 
     */
    protected $success;
    /**
     * Mensagem de erro
     *
     * @var string 
     */
    protected $errorMessage;
    
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

    
    /* Métodos para facilitar o uso dos dados de resposta da requisição */

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
    
}

