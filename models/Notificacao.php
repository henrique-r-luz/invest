<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

/**
 * This is the model class for table "notificacao".
 *
 * @property int $id
 * @property int $user_id
 * @property string $dados
 * @property bool $lido
 * @property int $created_at
 * @property int $updated_at
 */
class Notificacao extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'notificacao';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'dados'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['dados'], 'safe'],
            [['lido'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'dados' => 'Dados',
            'lido' => 'Lido',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
   
    
    public function afterSave($insert, $changedAttributes) {
       
        if($insert == true){
            $version = new Version2X(\Yii::$app->params['serverNode']);
            $client = new Client($version);
            $client->initialize();
            $client->emit("new_order", ['info' => 'atualiza Notificação']);
            $client->close();
        }
        parent::afterSave($insert, $changedAttributes);
    }

}
