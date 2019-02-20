<?php
include '../vendor/autoload.php';

use \BoletoFacil\Payment\PaymentItem;
use \BoletoFacil\Payment\Payer;
use \BoletoFacil\BoletoFacil;

$item = new PaymentItem();
$item->setDescricao("Produto XXXX");
$item->setDataVencimento("10/03/2019");
$item->setValor(10.50);
$item->setParcelas(4);

$pagador = new Payer();
$pagador->setNome("Nome do Cliente");
$pagador->setCpfCnpj("999.999.999-99");

$token = "meu_token_sandbox";
try
{
    $b = new BoletoFacil($token,"https://www.notifiqueaqui.com",true);
    var_dump($b->gerarCarne($item, $pagador));
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
