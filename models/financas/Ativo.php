<?php

namespace app\models\financas;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use yii\helpers\ArrayHelper;
use app\models\financas\Operacao;
use app\models\financas\Proventos;
use app\models\financas\ItensAtivo;
use app\lib\behavior\AuditoriaBehavior;
use app\models\config\ClassesOperacoes;
use app\models\financas\service\sincroniza\CotacaoCambio;

/**
 * This is the model class for table "public.ativo".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property string $pais
 * @property int $quantidade
 * @property double $valor_compra
 * @property double $valor_bruto
 * @property double $valor_liquido
 * @property int $tipo_id
 * @property int $categoria_id
 */
class Ativo extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public.ativo';
    }

    public function behaviors()
    {
        return [
            AuditoriaBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'tipo', 'categoria', 'pais', 'classe_atualiza_id'], 'required'],
            [['nome', 'codigo', 'categoria', 'tipo'], 'string'],
            [['acao_bolsa_id', 'classe_atualiza_id'], 'integer'],
            [['categoria'], 'string'],
            [['tipo'], 'validaDollar']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'codigo' => 'Código',
            'tipo' => 'Tipo',
            'categoria' => 'Categoria',
            'acao_bolsa_id' => 'Empresas',
            'pais' => 'País',
            'classe_atualiza_id' => 'Classe Atualização'
        ];
    }
    /**
     * Undocumented function
     *
     * @return void
     * @author Henrique Luz
     */
    public static function lucroPrejuizo()
    {
        $valorCompra = Ativo::find()
            ->sum(['valor_compra']);
        $valorLiquido = Ativo::find()
            ->sum(['valor_liquido']);
        return $valorLiquido - $valorCompra;
    }

    /**
     * @return ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(Tipo::class, ['id' => 'tipo_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOperacao()
    {
        return $this->hasMany(Operacao::class, ['ativo_id' => 'id']);
    }

    public function getItensAtivo()
    {
        return $this->hasMany(ItensAtivo::class, ['ativo_id' => 'id']);
    }

    public function getProvento()
    {
        return $this->hasMany(Proventos::class, ['ativo_id' => 'id']);
    }

    public function getAcaoBolsa()
    {
        return $this->hasOne(AcaoBolsa::class, ['id' => 'acao_bolsa_id']);
    }

    public function getInvestidor()
    {
        return $this->hasOne(Investidor::class, ['id' => 'investidor_id']);
    }

    public function getClassesOperacoes()
    {
        return $this->hasOne(ClassesOperacoes::class, ['id' => 'classe_atualiza_id']);
    }

    public static function lista()
    {
        return ArrayHelper::map(
            Ativo::find()->where(['ativo' => true])->all(),
            'id',
            function ($model) {
                return $model->codigo . ' | ' . $model->investidor->nome;
            }
        );
    }

    public static function listaAtivo()
    {
        return ArrayHelper::map(
            Ativo::find()->all(),
            'id',
            function ($model) {
                return $model->id . ' | ' . $model->codigo;
            }
        );
    }


    public function validaDollar()
    {
        if (
            isset($this->tipo) &&
            Tipo::DOLLAR == $this->tipo &&
            (Ativo::find()
                ->where(['tipo' => Tipo::DOLLAR])
                ->andFilterWhere(['<>', 'id', $this->id])
                ->exists())
        ) {
            $this->addError('tipo', 'Só pode ter um ativo com tipo Dollar.');
        }
    }
}
