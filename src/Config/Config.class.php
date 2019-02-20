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

namespace BoletoFacil\Config;

/**
 * Configurações da API
 *
 */
abstract class Config
{
    /**
     * URL de produção
     */
    const PRODUCTION_URL = 'https://www.boletobancario.com/boletofacil/integration/api/v1/';
    /**
     * URL de testes 
     */
    const SANDBOX_URL = 'https://sandbox.boletobancario.com/boletofacil/integration/api/v1/';
    /**
     * Tipo de resposta da API
     */
    const RESPONSE_TYPE = 'JSON';
    /**
     * Pagamento via boleto
     */
    const PAYMENT_BOLETO = 'BOLETO';
    /**
     * Pagamento via cartão
     */
    const PAYMENT_CREDIT_CARD = 'CREDIT_CARD';
    /**
     * Pagamento via boleto e/ou cartão
     */
    const PAYMENT_ALL = 'BOLETO,CREDIT_CARD';
}

