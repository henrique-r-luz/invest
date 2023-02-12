<?php

namespace app\models\config;

use Yii;

/**
 * This is the model class for table "public.classes_operacoes".
 *
 * @property int $id
 * @property string|null $nome
 */
class ClassesOperacoes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const CALCULA_POR_MEDIA_PRECO = 'app\lib\config\atualizaAtivos\rendaVariavel\CalculaPorMediaPreco';
    const CALCULA_ARITIMETICA = 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimetica';

    public static function tableName()
    {
        return 'public.classes_operacoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome'], 'required'],
            [['nome'], 'string',  'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'nome' => 'Nome',
        ];
    }
}
