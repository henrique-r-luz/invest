<?php

namespace cajui\lib\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use cajui\models\admin\Auditoria;

/**
 * Class AuditoriaBehavior
 *
 * @property \yii\db\ActiveRecord $owner
 *
 */
class AuditoriaBehavior extends Behavior
{
    /**
     * Is the behavior is ativo or not
     * @var boolean
     */
    public $ativo = true;

    /**
     * @var array
     */
    private $_oldAttributes = [];

    /**
     * @var array
     */
    private $_attributes = [];

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeUpdate()
    {
        //$this->setOldAttributes($this->owner->getOldAttributes());
    }

     /**
     * {@inheritdoc}
     */
    public function beforeInsert()
    {
       /* $this->auditar('INSERT');
        $this->setOldAttributes($this->owner->getOldAttributes());*/
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
       /* $this->setAttributes($this->owner->getAttributes());
        $this->auditar('DELETE');*/
    }

    /**
     * @param $action
     * @throws \yii\db\Exception
     */
    public function auditar($action)
    {
        // Não está ativo? sair.
        if (!$this->ativo) {
            return;
        }

        // Obter os atributos novos e antigos
        $auditoria = new Auditoria();

        if ($action == 'UPDATE') {
            $oldAttributes = $this->getOldAttributes();
            $changes       = [];
            foreach ($this->getAttributes() as $name => $value) {
                if (!array_key_exists($name, $this->getOldAttributes()) || $value != $oldAttributes[$name]) {
                    $changes[$name] = $value;
                }
            }

            // Se não houver diferença não registra
            if (count($changes) <= 0) {
                return;
            }
            $auditoria->created_by = $this->owner->updated_by;
            $auditoria->created_at = $this->owner->updated_at;
        } else {
            $changes               = $this->getAttributes();
            $auditoria->created_by = Yii::$app->session->get('user.idUserInicial') ?? Yii::$app->user->id;
            $auditoria->created_at = time();
        }

        // Dados auditados
        $auditoria->model    = get_class($this->owner);
        $auditoria->model_id = $this->getNormalizedPk();
        $auditoria->operacao = $action;
        $auditoria->changes  = $changes;

        $auditoria->save();
    }

    /**
     * @return array
     */
    public function getOldAttributes()
    {
        return $this->_oldAttributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

    /**
     * @param $value
     */
    public function setOldAttributes($value)
    {
        $this->_oldAttributes = $value;
    }

    /**
     * @param $value
     */
    public function setAttributes($value)
    {
        $this->_attributes = $value;
    }

    /**
     * Quando a chave primaria for composta retorna em formato json.
     * @return string
     */
    protected function getNormalizedPk()
    {
        $pk = $this->owner->getPrimaryKey();
        return is_array($pk) ? json_encode($pk) : (string) $pk;
    }
}
