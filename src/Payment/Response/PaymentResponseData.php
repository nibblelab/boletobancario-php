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
 * Dados da resposta 
 */
class PaymentResponseData
{
    /**
     * lista do que foi cobrado
     *
     * @var array 
     */
    private $charges;
    /**
     * lista com detalhes do pagamento
     *
     * @var array 
     */
    private $payments;
    
    public function __construct()
    {
        $this->charges = array();
        $this->payments = array();
    }
    
    /**
     * Obtêm a lista do que foi cobrado
     * 
     * @return array
     */
    public function getCharges(): array
    {
        return $this->charges;
    }
    
    /**
     * Seta a lista do que foi cobrado
     * 
     * @param array $charges
     */
    public function setCharges($charges)
    {
        $this->charges = $charges;
    }

    /**
     * Obtêm a lista com detalhes do pagamento
     * 
     * @return array
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * Seta a lista com detalhes do pagamento
     * 
     * @param array $payments
     */
    public function setPayments($payments)
    {
        $this->payments = $payments;
    }

}

