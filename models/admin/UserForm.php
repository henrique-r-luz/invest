<?php

namespace app\models\admin;

use app\models\admin\User;
use yii\helpers\ArrayHelper;

class UserForm extends User
{

    public  $confirma;
    public  $grupo;


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['confirma','grupo'], 'required'],
            [['confirma','grupo'], 'string'],
            [['password'],'confirmaSenha']
        ]);
    }


    public function attributeLabels(){
        return ArrayHelper::merge(parent::attributeLabels(), [
            'confirma'=>'Confirma Senha',
            'grupo'=>'Grupo permissão'
        ]);
    }


    public function attributeComments(){
        return ArrayHelper::merge(parent::attributeComments(), [
            'confirma'=>'Confirma Senha',
            'grupo'=>'Grupo permissão'
        ]);
    }

    public function confirmaSenha(){
        if($this->password!==$this->confirma){
            $this->addError('password','A senha é diferente da confirmação de senha! ');
            return false;
        }
    }
}
