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

namespace BoletoFacil\Error;

/**
 * Enumeração de erros possíveis
 */
abstract class Errors
{
    /**
     * lib curl não está presente
     */
    const CURL_NOT_FOUND = -1;
    /**
     * Requisição vazia
     */
    const EMPTY_REQUEST = -2;
    /**
     * Erro no curl
     */
    const CURL_ERROR = -3;
    /**
     * Erro de validação dos dados
     */
    const VALIDATION_ERROR = -4;
    /**
     * Erro ao processar a requisição
     */
    const REQUEST_ERROR = -5;
    /**
     * Requisição incorreta
     */
    const INCORRECT_REQUEST = -6;
}

