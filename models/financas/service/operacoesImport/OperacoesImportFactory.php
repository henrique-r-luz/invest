<?php

namespace app\models\financas\service\operacoesImport;

use app\lib\dicionario\TipoArquivoUpload;
use app\models\financas\Operacao;

class OperacoesImportFactory
{
    public static function getObjeto($operacoesImport)
    {

        switch ($operacoesImport->tipo_arquivo) {
            case TipoArquivoUpload::CLEAR:
                return new OperacaoClear($operacoesImport);
            case TipoArquivoUpload::AVENUE:
                return new OperacaoAvenue($operacoesImport);
            case TipoArquivoUpload::NU:
                return new OperacaoNu($operacoesImport);
            case TipoArquivoUpload::PROVENTOS:
                return new OperacaoProventos($operacoesImport);
        }
    }
}
