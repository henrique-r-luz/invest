<?php

namespace app\models\financas\service\operacoesImport;

use app\lib\dicionario\TipoArquivoUpload;
use app\lib\helpers\InvestException;
use app\models\financas\Operacao;

class OperacoesImportFactory
{
    public static function getObjeto($operacoesImport)
    {

        switch ($operacoesImport->tipo_arquivo) {
            case TipoArquivoUpload::CLEAR:
                return new OperacaoClear($operacoesImport);
            case TipoArquivoUpload::AVENUE:
                throw new InvestException("Não implementado");
            case TipoArquivoUpload::NU:
                return new OperacaoNu($operacoesImport);
            case TipoArquivoUpload::PROVENTOS_CLEAR:
                return new OperacaoProventos($operacoesImport);
            case TipoArquivoUpload::PROVENTOS_AVENUE:
                return new OperacaoProventosAvenue($operacoesImport);
        }
    }
}
