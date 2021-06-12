<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;

/**
 * Class m190609_143226_inicio
 */
class m210612_095630_popula_ativo extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {

        $ativos = Ativo::find()->all();
        foreach ($ativos as $ativo) {
            $this->update('ativo', ['investidor_id' => 1], ['id' => $ativo->id]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
        true;
    }

}
