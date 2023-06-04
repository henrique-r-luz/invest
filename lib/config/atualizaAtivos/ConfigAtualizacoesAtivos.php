<?php

namespace app\lib\config\atualizaAtivos;

use app\models\financas\Operacao;
use app\lib\config\atualizaAtivos\FormOperacoes;

class ConfigAtualizacoesAtivos
{
    //private FormOperacoes $formOperacoes;
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
        return $this->config[$operacoa];
    }
}
