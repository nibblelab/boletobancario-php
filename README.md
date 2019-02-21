
# Biblioteca de integração com a API de geração de pagamentos via boleto e cartão fornecida pela Boleto Bancário

A especificação da API pode ser encontrada em https://www.boletobancario.com/boletofacil/integration/integration.html


## Pré requisitos

* PHP >= 7.1.0
* libcurl
* composer

## Instalação

Instale pelo composer

```
$ composer require nibblelab/boletobancario-php
```


## Requisição de Pagamento


Para requisitar um pagamento primeiro crie os dados do mesmo, assim como quem está pagando

```
include './vendor/autoload.php';

use BoletoFacil\Payment\PaymentItem;
use BoletoFacil\Payment\Payer;
use BoletoFacil\BoletoFacil;

$item = new PaymentItem();
$item->setDescricao("Descrição"); # texto de descrição do pagamento
$item->setDataVencimento("99/99/9999"); # data de vencimento, no formato DD/MM/YYYY
$item->setValor(10.50); # valor do pagamento
$item->setReferencia("Id interno"); # referência do pagamento que me permita linkar o registro interno do meu sistema com o do boleto fácil

$pagador = new Payer();
$pagador->setNome("Teste de Teste"); # nome do pagador
$pagador->setCpfCnpj("099.999.999-99"); # CPF do pagador
```


### Pagamento via Boleto


```
$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $url = $b->gerarBoleto($item, $pagador); # gera o boleto e obtem a URL de checkout
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pagamento via Carnê


```
$item->setParcelas(2); # carnê possui duas ou mais parcelas
$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $urls = $b->gerarCarne($item, $pagador); # gera o boleto e obtem as URLs de checkout
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pagamento via Cartão


```
$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $url = $b->gerarPagtoCartao($item, $pagador); # gera o pagamento e obtem a URL de checkout
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pagamento via Cartão com antecipação de parcelas


```
$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $url = $b->gerarPagtoCartao($item, $pagador, true); # gera o pagamento e obtem a URL de checkout
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pagamento via Cartão ou boleto


```
$token = "seu_token"; # token de produção ou sandbox
$antecipar = false; # flag para permitir ou não a antecipação de parcelas
try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $url = $b->gerarBoletoOuCartao($item, $pagador, $antecipar); # gera o pagamento e obtem a URL de checkout
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pagamento Transparente via Cartão


O hash do cartão é obrigatório nessa modalidade de pagamento. Instruções de como gerar esse campo estão em: https://www.boletobancario.com/boletofacil/integration/integration.html#credit_card_hash

```
$token = "seu_token"; # token de produção ou sandbox
$hash_cartao = "hash_cartao"; # hash do cartão de crédito 

try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $b->gerarPagtoCartaoTransparente($item, $pagador, $hash_cartao); # gera o pagamento

    $status = $b->getPaymentResponse()->getData()->getPayments()[0]->getStatus(); # obtendo o status da transação
    if($status == 'AUTHORIZED' || $status == 'CONFIRMED') # pagamento permitido
    {
        $id_cartao = $b->getPaymentResponse()->getData()->getPayments()[0]->getCreditCardId(); # obtendo o id do cartão
    }
    else if($status == 'DECLINED' || $status == 'FAILED' || $status == 'NOT_AUTHORIZED') # pagamento não permitido 
    {
        
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pagamento Transparente via Cartão com armazenamento de cartão


O hash do cartão é obrigatório nessa modalidade de pagamento. Instruções de como gerar esse campo estão em: https://www.boletobancario.com/boletofacil/integration/integration.html#credit_card_hash

É possível armazenar o cartão de crédito para futuros pagamentos. Se for o caso, o Boleto Fácil gerará um id que pode ser enviado em futuras transações de pagamento transparente.

```
$token = "seu_token"; # token de produção ou sandbox
$hash_cartao = "hash_cartao"; # hash do cartão de crédito 

$id_cartao = ''; # id de cartão previamente armazenado
$armazenar_cartao = true; # flag para indicar se o cartão será armazenado ou não
try
{
    //$b = new BoletoFacil($token,"sua url de notificação",true); # modo sandbox
    $b = new BoletoFacil($token,"sua url de notificação"); # modo produção
    $b->gerarPagtoCartaoTransparente($item, $pagador, $hash_cartao, $id_cartao, $armazenar_cartao); # gera o pagamento

    $status = $b->getPaymentResponse()->getData()->getPayments()[0]->getStatus(); # obtendo o status da transação
    if($status == 'AUTHORIZED' || $status == 'CONFIRMED') # pagamento permitido
    {
        
    }
    else if($status == 'DECLINED' || $status == 'FAILED' || $status == 'NOT_AUTHORIZED') # pagamento não permitido 
    {
        
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


## Notificação de Pagamento


A API Boleto Fácil notifica as mudanças no status do pagamento para a url que informou durante a requisição de pagamento.

Para processar essa notificação e obter os dados use

```
include './vendor/autoload.php';

use BoletoFacil\BoletoFacil;

$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"",true); # modo sandbox
    $b = new BoletoFacil($token); # modo produção
    $b->processarNotificacao(); # processa a requisição
    
    $valor_pago = $b->getNotificationResponse()->getValorPago(); # obtendo o valor pago
    $valor_taxas = $b->getNotificationResponse()->getValorTaxas(); # obtendo o valor das taxas
    $valor_cobrado = $b->getNotificationResponse()->getValorCobrado(); # obtendo o valor cobrado
    $referencia = $b->getNotificationResponse()->getPagtoReferencia(); # obtendo a referência do pagamento fornecida durante o pagamento
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


## Busca de pagamentos


### Pela data de vencimento


```
include './vendor/autoload.php';

use BoletoFacil\BoletoFacil;

$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"",true); # modo sandbox
    $b = new BoletoFacil($token); # modo produção
    $pagamentos = $b->buscarPagamentosPorDataVencimento('99/99/9999'); # busca os pagamentos que venceram após a data fornecida
    # itere sobre os pagamentos
    foreach($pagamentos as $pagto)
    {
        $data_vencimento = $pagto->getDueDate(); # data de vencimento
        # liste os pagamentos do registro
        foreach($pagto->todosOsPagamentos() as $p) {
            $data_pagto = $p->getDate(); # data do pagamento
            $valor_pago = $p->getAmount(); # valor pago
            $valor_taxas = $p->getFee(); # valor das taxas
            $tipo_pagto = $p->getType(); # tipo do pagamento
            $status_pagto = $p->getStatus(); # status do pagamento
        }
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pela data de pagamento


```
include './vendor/autoload.php';

use BoletoFacil\BoletoFacil;

$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"",true); # modo sandbox
    $b = new BoletoFacil($token); # modo produção
    $pagamentos = $b->buscarPagamentosPorDataPagto('99/99/9999'); # busca os pagamentos que foram pagos após a data fornecida
    # itere sobre os pagamentos
    foreach($pagamentos as $pagto)
    {
        $data_vencimento = $pagto->getDueDate(); # data de vencimento
        # liste os pagamentos do registro
        foreach($pagto->todosOsPagamentos() as $p) {
            $data_pagto = $p->getDate(); # data do pagamento
            $valor_pago = $p->getAmount(); # valor pago
            $valor_taxas = $p->getFee(); # valor das taxas
            $tipo_pagto = $p->getType(); # tipo do pagamento
            $status_pagto = $p->getStatus(); # status do pagamento
        }
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


### Pela data de confirmação de pagamento


```
include './vendor/autoload.php';

use BoletoFacil\BoletoFacil;

$token = "seu_token"; # token de produção ou sandbox
try
{
    //$b = new BoletoFacil($token,"",true); # modo sandbox
    $b = new BoletoFacil($token); # modo produção
    $pagamentos = $b->buscarPagamentosPorDataConfirmacaoPagto('99/99/9999'); # busca os pagamentos que foram confirmados após a data fornecida
    # itere sobre os pagamentos
    foreach($pagamentos as $pagto)
    {
        $data_vencimento = $pagto->getDueDate(); # data de vencimento
        # liste os pagamentos do registro
        foreach($pagto->todosOsPagamentos() as $p) {
            $data_pagto = $p->getDate(); # data do pagamento
            $valor_pago = $p->getAmount(); # valor pago
            $valor_taxas = $p->getFee(); # valor das taxas
            $tipo_pagto = $p->getType(); # tipo do pagamento
            $status_pagto = $p->getStatus(); # status do pagamento
        }
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}
```


## License

Este projeto está licenciado com Apache - veja [LICENSE.md](LICENSE.md) pra mais detalhes
