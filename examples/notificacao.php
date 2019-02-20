<?php
include '../vendor/autoload.php';

use \BoletoFacil\BoletoFacil;

$token = "meu_token_sandbox";
try
{
    $b = new BoletoFacil($token,"",true);
    $b->processarNotificacao();
    
    echo 'valor pago = ' . $b->getNotificationResponse()->getValorPago() . '<br>';
    echo 'valor das taxas = ' . $b->getNotificationResponse()->getValorTaxas() . '<br>';
    echo 'valor cobrado = ' . $b->getNotificationResponse()->getValorCobrado() . '<br>';
    echo 'referência = ' . $b->getNotificationResponse()->getPagtoReferencia() . '<br>';
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
