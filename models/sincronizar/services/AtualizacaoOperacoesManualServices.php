<?php

namespace app\models\sincronizar\services;

use app\lib\CajuiHelper;
use app\lib\helpers\InvestException;
use app\models\financas\ItensAtivo;
use app\models\sincronizar\AtualizaOperacoesManual;

class AtualizacaoOperacoesManualServices
{
    private AtualizaOperacoesManual $atualizaOperacoesManual;

    public function __construct($atualizaOperacoesManual = null)
    {
        if ($atualizaOperacoesManual == null) {
            $this->atualizaOperacoesManual = new AtualizaOperacoesManual();
        } else {
            $this->atualizaOperacoesManual = $atualizaOperacoesManual;
        }
    }

    public function load($post)
    {
        return $this->atualizaOperacoesManual->load($post);
    }

    public function salvar()
    {
        $this->salvaOperacaoManual();
        $this->atualizaItensAtivo();
    }

    private function salvaOperacaoManual()
    {
        if (!$this->atualizaOperacoesManual->save()) {
            $erro  = CajuiHelper::processaErros($this->atualizaOperacoesManual->getErrors());
            throw new InvestException($erro);
        }
    }

    private function atualizaItensAtivo()
    {
        if ($this->verificaUltimoRegistro()) {
            return true;
        }

        $itensAtivos = ItensAtivo::findOne($this->atualizaOperacoesManual->atualizaAtivoManual->itens_ativo_id);
        $itensAtivos->valor_bruto = $this->atualizaOperacoesManual->valor_bruto;
        $itensAtivos->valor_liquido = $this->atualizaOperacoesManual->valor_liquido;
        if (!$itensAtivos->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivos->getErrors());
            throw new InvestException($erro);
        }
    }

    private function verificaUltimoRegistro()
    {

        if (AtualizaOperacoesManual::find()
            ->where(['>', 'data', $this->atualizaOperacoesManual->data])
            ->exists()
        ) {
            return true;
        }
        return false;
    }

    public function getId()
    {
        return $this->atualizaOperacoesManual->id;
    }
}
