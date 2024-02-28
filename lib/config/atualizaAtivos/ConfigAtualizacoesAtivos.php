<?php

namespace app\lib\config\atualizaAtivos;

use app\models\financas\Operacao;
use app\lib\helpers\InvestException;

class ConfigAtualizacoesAtivos
{
    private array $config;

    public function __construct(FormOperacoes $formOperacoes)
    {
        $this->config[Operacao::tipoOperacaoId()[Operacao::COMPRA]] = $formOperacoes->compra;

        $this->config[Operacao::tipoOperacaoId()[Operacao::VENDA]] = $formOperacoes->venda;

        $this->config[Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS]] = $formOperacoes->desdobraMais;

        $this->config[Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS]] = $formOperacoes->desdobraMenos;
    }

    public function getClasse(string $operacoa)
    {
        if (isset($this->config[$operacoa])) {
            return $this->config[$operacoa];
        }

        throw new InvestException("Operação não foi implementada na Classe: CalculaAritimeticaCDBInter");
    }
}
