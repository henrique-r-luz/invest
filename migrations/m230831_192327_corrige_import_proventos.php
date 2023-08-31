<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\financas\OperacoesImport;
use app\lib\dicionario\TipoArquivoUpload;
use yii\db\Expression;

/**
 * Class m190609_143226_inicio
 */
class m230831_192327_corrige_import_proventos extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $imporProventos = OperacoesImport::find()
            ->where(['<>', 'id', 36])
            ->andWhere(['tipo_arquivo' => TipoArquivoUpload::PROVENTOS])
            ->all();
        foreach ($imporProventos as  $import) {
            if ($import->lista_operacoes_criadas_json != null) {
                $operacoes_id = \json_decode($import->lista_operacoes_criadas_json, true);
                foreach ($operacoes_id as $id) {
                    $this->update('proventos', ['data' => new Expression(" data + INTERVAL '1 DAY' ")], ['id' => $id]);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $imporProventos = OperacoesImport::find()
            ->where(['<>', 'id', 36])
            ->andWhere(['tipo_arquivo' => TipoArquivoUpload::PROVENTOS])
            ->all();
        foreach ($imporProventos as  $import) {
            if ($import->lista_operacoes_criadas_json != null) {
                $operacoes_id = \json_decode($import->lista_operacoes_criadas_json, true);
                foreach ($operacoes_id as $id) {
                    $this->update('proventos', ['data' => new Expression(" data - INTERVAL '1 DAY' ")], ['id' => $id]);
                }
            }
        }
    }
}
