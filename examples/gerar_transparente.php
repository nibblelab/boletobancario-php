<?php
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
