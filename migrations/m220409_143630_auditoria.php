<?php

namespace app\migrations;

use Yii;
use app\models\User;
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
        // Criação da tabela de auditoria
        $this->createTable('auditoria', [
            'id'         => $this->primaryKey(),
            'model'      => $this->text()->notNull(),
            'operacao'   => $this->text()->notNull(),
            'changes'    => 'JSONB NOT NULL',
            'user_id'       => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'FOREIGN KEY (user) REFERENCES public.user (id)',
        ]);
        $this->addCommentOnTable('basico.auditoria', 'Auditoria de tabelas. registra alterações numa tabela.');
        $this->addCommentOnColumn('basico.auditoria', 'id', 'Identificador do registro de alteração numa tabela.');
        $this->addCommentOnColumn('basico.auditoria', 'model', 'Classe modelo que representa a tabela alterada.');
        $this->addCommentOnColumn('basico.auditoria', 'operacao', 'Operação que alterou a tabela: INSERT, DELETE, TRUNCATE.');
        $this->addCommentOnColumn('basico.auditoria', 'changes', 'Registra diferença após alteração da tabela.');
        $this->addCommentOnColumn('basico.auditoria', 'user', 'Identificador do usuário que executou a operação');
        $this->addCommentOnColumn('basico.auditoria', 'created_at', 'Identificador do registro de alteração numa tabela');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('auditoria')
    }
}
