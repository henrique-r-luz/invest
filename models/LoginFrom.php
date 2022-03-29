<?php


namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Usuario;

class LoginFrom extends Model
{
   
    public $nome;
    public $senha;
    private $user;

    public function rules(){
        return [
            [['nome', 'senha'], 'required'],
        ];
    }


    public function login(){
        $this->getUser();
        if($this->verificaSenha()){
            return Yii::$app->user->login($this->user);
        }

        return false;

    }

    public function verificaSenha(){
        if($this->user->senha==$this->senha){
            return true;
        }
        $this->addError('senha','senha incorreta! ');
        return false;
    }

    private function getUser():Usuario{
        $this->user = Usuario::find()->where(['nome'=>$this->nome])->one(); 
        return $this->user;
    }
    
}
