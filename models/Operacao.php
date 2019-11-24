<?php

namespace app\models;

use app\lib\CajuiHelper;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "public.operacao".
 *
 * @property int $id
 * @property string $tipo
 * @property int $quantidade
 * @property double $valor
 * @property string $data
 * @property int $ativo_id
 */
class Operacao extends ActiveRecord {

    const VENDA = 'Venda';
    const COMPRA = 'Compra';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'public.operacao';
    }

    /**
     * {@inheritdoc}
     */
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
            [['tipo', 'quantidade', 'valor', 'data', 'ativo_id'], 'required'],
            [['quantidade', 'ativo_id'], 'default', 'value' => null],
            [['ativo_id', 'tipo'], 'integer'],
            [['valor', 'quantidade'], 'number'],
            [['data'], 'safe'],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'quantidade' => 'Quantidade',
            'valor' => 'Valor',
            'data' => 'Data',
            'ativo_id' => 'Ativo ID',
        ];
    }

    /**
     * retorna o tipo de operação
     * @return type
     */
    public static function tipoOperacao() {
        return [
            0 => self::VENDA,
            1 => self::COMPRA,
        ];
    }

    public static function getTipoOperacao($id) {
        return self::tipoOperacao()[$id];
    }

    /**
     * @return ActiveQuery
     */
    public function getAtivo() {
        return $this->hasOne(Ativo::class, ['id' => 'ativo_id']);
    }

    /**
     * Dalva Operação.
     * Essa função realiza uma transação com a tabela ativo.
     * garantido a atualização da quantidade e valor de compra
     */
    public function salvaOperacao() {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            if ($this->save()) {
                if ($this->alteraAtivo()) {
                    list($sincroniza) = Yii::$app->createController('sicronizar/index');
                    list($resp, $msg) = $sincroniza->cotacaoAcao();
                    if($resp==true){
                        list($resp, $msg) = $sincroniza->easy();
                        if($resp==true){
                            $transaction->commit();
                            return true;
                        }else{
                              $this->addError('ativo_id', 'O sistema não pode sincronizar os dados de renda fixa. ');
                            $transaction->rollBack();
                            return false;
                        }
                    }else{
                        $this->addError('ativo_id', 'O sistema não pode sincronizar os dados de ações. ');
                        $transaction->rollBack();
                        return false;
                    }
                    
                } else {
                    $transaction->rollBack();
                    $this->addError('ativo_id', 'O sistema não pode alterar o ativo:' . $this->ativo->codigo . '. ');
                    return false;
                }
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Deleta Operação.
     * Essa função realiza uma transação com a tabela ativo.
     * garantido a atualização da quantidade e valor de compra
     */
    public function deletaOperacao() {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
            if ($this->delete()) {
                if ($this->alteraAtivo()) {
                    list($sincroniza) = Yii::$app->createController('sicronizar/index');
                    list($resp, $msg) = $sincroniza->cotacaoAcao();
                    if($resp==true){
                        list($resp, $msg) = $sincroniza->easy();
                        if($resp==true){
                            $transaction->commit();
                            return true;
                        }else{
                              $this->addError('ativo_id', 'O sistema não pode sincronizar os dados de renda fixa. ');
                            $transaction->rollBack();
                            return false;
                        }
                    }else{
                        $this->addError('ativo_id', 'O sistema não pode sincronizar os dados de ações. ');
                        $transaction->rollBack();
                        return false;
                    }
                    
                } else {
                    $transaction->rollBack();
                    $this->addError('ativo_id', 'O sistema não pode alterar o ativo:' . $this->ativo->codigo . '. ');
                    return false;
                }
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * atualiza o registro de ativos ao salvar operação.
     * campos alterados quantidade e valor de compra
     * @return boolean
     */
    public function alteraAtivo() {
        $ativo = Ativo::findOne($this->ativo_id);

        $ativo->quantidade = self::find()->where(['ativo_id' => $this->ativo_id])
                        ->andWhere(['tipo' => 1])//compra
                        ->sum('quantidade') -
                        self::find()->where(['ativo_id' => $this->ativo_id])
                        ->andWhere(['tipo' => 0])//venda
                        ->sum('quantidade');

        if ($ativo->quantidade <= 0) {
            $ativo->valor_compra = 0;
            $ativo->valor_bruto = 0;
            $ativo->valor_liquido = 0;
        } else {

            $ativo->valor_compra = self::find()->where(['ativo_id' => $this->ativo_id])
                            ->andWhere(['tipo' => 1])//compra
                            ->sum('valor') -
                            self::find()->where(['ativo_id' => $this->ativo_id])
                            ->andWhere(['tipo' => 0])//venda
                            ->sum('valor');
        }


        if ($ativo->save()) {
            return true;
        } else {
            $erro = CajuiHelper::processaErros($ativo->getErrors());
            Yii::$app->session->setFlash('danger', 'Erro ao salvar ativo!</br>' . $erro);
            return false;
        }
    }

}
