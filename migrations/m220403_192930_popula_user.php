<?php

namespace app\migrations;

use Yii;
use app\models\admin\User;
use yii\db\Migration;

/**
 * type 1 são os pápeis 
 * type 2 são as regras
 * 
 */
class m220403_192930_popula_user extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('public.user', ['username' => 'admin', 'password' => Yii::$app->getSecurity()->generatePasswordHash('admin')]);
        $this->insert('public.auth_item', ['name' => 'admin', 'type' => '1', 'description' => 'papel do administrador']);
        $user = User::find()->where(['username'=>'admin'])->one();
        $this->insert('public.auth_assignment', ['user_id' => $user->id, 'item_name' => 'admin']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('public.auth_assignment', ['item_name' => 'admin']);
        $this->delete('public.auth_item', ['name' => 'admin']);
        $this->delete('public.user', ['username' => 'admin']);
    }
}
