<?php

namespace app\lib\behavior;

use app\lib\CajuiHelper;
use Yii;
use yii\helpers\Json;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\admin\Auditoria;
use Throwable;
use yii\db\Transaction;

/**
 * Class AuditoriaBehavior
 *
 * @property \yii\db\ActiveRecord $owner
 *
 */
class AuditoriaBehavior extends Behavior
{

    private $action;
    private $changes = [];
    private $erros = [];
    private $transaction;

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }




    public function beforeInsert()
    {
        $this->transaction =  Yii::$app->db->beginTransaction();
    }

    /**
     * {@inheritdoc}
     */
    public function afterInsert()
    {
        $this->action = 'insert';
        $this->insereAfterAuditoria();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeUpdate()
    {
        $this->action = 'update';
        $this->insereBeforeAuditoria();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        $this->action = 'delete';
        $this->insereBeforeAuditoria();
    }


    public function  insereBeforeAuditoria()
    {
        if (!$this->saveAuditoria()) {
            throw new \Exception("Error ao inserir auditoria:</br>" . $this->erros);
        }
    }

    public function  insereAfterAuditoria()
    {
        try {
            if (!$this->saveAuditoria()) {
                $this->transaction->rollBack();
                throw new \Exception("Error ao inserir auditoria:</br>" . $this->erros);
            }
            $this->transaction->commit();
        } catch (Throwable $e) {
            $this->transaction->rollBack();
            throw new \Exception("Error ao inserir auditoria");
        }
    }


    private function saveAuditoria()
    {
        $this->changes       = [];
        foreach ($this->owner->getAttributes() as $name => $value) {
            $this->changes[$name] = $value;
        }
        $auditoria = new Auditoria();
        $auditoria->model    = get_class($this->owner);
        $auditoria->operacao = $this->action;
        $auditoria->changes  = $this->changes;
        $auditoria->user_id =  Yii::$app->user->id;
        $auditoria->created_at = time();
        if (!$auditoria->save()) {
            $this->erros = CajuiHelper::processaErros($this->owner->getErrors());
            return false;
        }
        return true;
    }
}
