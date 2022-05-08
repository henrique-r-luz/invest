<?php

namespace app\controllers\admin\services;


use Exception;
use app\lib\Cache;
use app\lib\CajuiHelper;
use app\models\admin\Auditoria;
use app\models\admin\UserForm;
use app\models\admin\AuthAssignment;
use yii\rbac\Permission;

class UserServices
{

    private UserForm $userForm;


    function __construct(UserForm $userForm = null)
    {
        $this->userForm = $userForm ?? new UserForm();
    }


    public function loadUpdate($post)
    {
        
        $resp  = $this->userForm->load($post);
        $permissao = $this->getPermissao();
        if(empty(!$permissao)){
            $this->userForm->grupo = $permissao->item_name;
        }
        return $resp;

    }


    public function load($post)
    {
        return $this->userForm->load($post);
    }



    public function save()
    {
        $this->salvaUser();
        $this->atribuiPermissao();
        Cache::getCache('cache')->flush();
    }


    private function salvaUser()
    {
        if (!$this->userForm->save()) {
            $erro = CajuiHelper::processaErros($this->userForm->getErrors());
            throw new Exception('Ocorreu um erro ao salvar usuário! </br>' . $erro);
        }
    }


    private function atribuiPermissao()
    {
        $user_id = (string) $this->userForm->id;
        $permissao = $this->getPermissao();
        if (empty($permissao)) {
            $permissao = new AuthAssignment();
        }
        $permissao->item_name = $this->userForm->grupo;
        $permissao->user_id = (string) $this->userForm->id;
        $erro = CajuiHelper::processaErros($permissao->getErrors());
        if (!$permissao->save()) {
            throw new Exception('Erro ao atribuir permissão! </br>' . $erro);
        }
    }


    public function delete()
    {
        if(Auditoria::find()->where(['user_id'=>$this->userForm->id])->exists()){
            throw  new Exception('Há registros de auditoria vinculado ao usuário !');
        }
        $permissao = $this->getPermissao();
        if (!empty($permissao)) {
            $permissao->delete();
        }
        
        $this->userForm->delete();
    }

    private function getPermissao()
    {
        return  AuthAssignment::find()
            ->andFilterWhere(['item_name' => $this->userForm->grupo])
            ->andWhere(['user_id' => (string) $this->userForm->id])->one();
    }


    public function getUser()
    {
        return $this->userForm;
    }
}
