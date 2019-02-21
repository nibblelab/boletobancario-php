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

use \BoletoFacil\BoletoFacil;


$token = "meu_token_sandbox";
try
{
    $b = new BoletoFacil($token,"",true);
    $cobrancas = $b->buscarCobrancasPorDataVencimento('01/01/2019');
    // liste todos
    foreach($cobrancas as $c) {
        echo ' data vencimento = ' . $c->getDueDate()->format('d/m/Y') . '<br>';
        foreach($c->todosOsPagamentos() as $p) {
            echo ' data pagto = ' . $p->getDate()->format('d/m/Y') . '<br>';
        }
    }
    // liste um específico
    if(count($cobrancas) >= 1) {
        $c = $b->getFetchResponse()->dadosCobranca(1);
        echo ' data vencimento = ' . $c->getDueDate()->format('d/m/Y') . '<br>';
        // também liste específico dos detalhes do pagto
        $detalhes = $c->todosOsPagamentos();
        if(count($detalhes) >= 1) {
            $p = $c->dadosPagamento(1);
            echo ' data pagto = ' . $p->getDate()->format('d/m/Y') . '<br>';
        }
    }
}
catch(Exception $ex)
{
    echo $ex->getMessage();
}

