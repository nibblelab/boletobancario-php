
# Biblioteca de integração com a API de geração de pagamentos via boleto e cartão fornecida pela Boleto Bancário

A especificação da API pode ser encontrada em https://www.boletobancario.com/boletofacil/integration/integration.html

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