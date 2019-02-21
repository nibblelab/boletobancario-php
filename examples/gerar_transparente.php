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

include '../vendor/autoload.php';

use \BoletoFacil\Payment\PaymentItem;
use \BoletoFacil\Payment\Payer;
use \BoletoFacil\BoletoFacil;

$item = new PaymentItem();
$item->setDescricao("Produto XXXX");
$item->setDataVencimento("10/03/2019");
$item->setValor(10.50);
$item->setReferencia("meu id interno");

$pagador = new Payer();
$pagador->setNome("Nome do Cliente");
$pagador->setCpfCnpj("999.999.999-99");

$token = "meu_token_sandbox";
$hash_cartao = "hash do cartão de crédito";
try
{
    $b = new BoletoFacil($token,"https://www.notifiqueaqui.com",true);
    $b->gerarPagtoCartaoTransparente($item, $pagador, $hash_cartao);
    
    $status = $b->getPaymentResponse()->getData()->getPayments()[0]->getStatus();
    if($status == 'AUTHORIZED') 
    {
        echo 'Pagamento autorizado';
        $id_cartao = $b->getPaymentResponse()->getData()->getPayments()[0]->getCreditCardId();
    }
    else if($status == 'CONFIRMED') 
    {
        echo 'Pagamento confirmado';
        $id_cartao = $b->getPaymentResponse()->getData()->getPayments()[0]->getCreditCardId();
    }
    else if($status == 'DECLINED') 
    {
        echo 'Pagamento rejeitado';
    }
    else if($status == 'FAILED') 
    {
        echo 'Pagamento não realizado';
    }
    else if($status == 'NOT_AUTHORIZED') 
    {
        echo 'Pagamento não autorizado';
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
