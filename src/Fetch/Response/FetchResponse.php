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

namespace BoletoFacil\Fetch\Response;

use BoletoFacil\Fetch\Response\FetchResponseData;
use BoletoFacil\Response\Response;

/**
 * Resposta da busca
 */
class FetchResponse extends Response
{
    /**
     * Dados da resposta em caso de sucesso
     *
     * @var array
     */
    private $data;
    
    /**
     * Obtêm os dados 
     * 
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Seta os dados
     * 
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
    
    /* Métodos para facilitar o uso dos dados de resposta da busca */
    
    /**
     * Obtêm dados do que foi cobrado no pagamento
     * 
     * @param int $index índice da cobrança na lista. Padrão = 0
     * @return FetchResponseData|null
     */
    public function dadosCobranca($index = 0): ?\BoletoFacil\Fetch\Response\FetchResponseData
    {
        if(count($this->data) > 0)
        {
            return $this->data[$index];
        }
        
        return null;
    }
    
    /**
     * Obtêm a lista de cobranças
     * 
     * @return array
     */
    public function todasAsCobrancas(): array
    {
        return $this->data;
    }
}