<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Historia".
 *
 * @property string $id
 * @property string $autor
 * @property string $nome
 * @property string $descricao
 * @property integer $qteGostei
 * @property integer $qteNaoGostei
 * @property integer $qteDenuncias
 * @property integer $duracao
 * @property integer $status
 * @property string $moderador
 *
 * @property Usuario $autor0
 * @property Moderador $moderador0
 * @property UsuarioComentaHistoria[] $usuarioComentaHistorias
 * @property UsuarioDenunciaHistoria[] $usuarioDenunciaHistorias
 * @property Usuario[] $usuarios
 * @property UsuarioReageHistoria[] $usuarioReageHistorias
 * @property Usuario[] $usuarios0
 */
class Historia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Historia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['descricao'], 'string'],
            [['qteGostei', 'qteNaoGostei', 'qteDenuncias', 'duracao', 'status'], 'integer'],
            [['id'], 'string', 'max' => 6],
            [['autor', 'nome', 'moderador'], 'string', 'max' => 20],
            [['autor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['autor' => 'username']],
            [['moderador'], 'exist', 'skipOnError' => true, 'targetClass' => Moderador::className(), 'targetAttribute' => ['moderador' => 'login']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'autor' => 'Autor',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
            'qteGostei' => 'Qte Gostei',
            'qteNaoGostei' => 'Qte Nao Gostei',
            'qteDenuncias' => 'Qte Denuncias',
            'duracao' => 'Duracao',
            'status' => 'Status',
            'moderador' => 'Moderador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor0()
    {
        return $this->hasOne(Usuario::className(), ['username' => 'autor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModerador0()
    {
        return $this->hasOne(Moderador::className(), ['login' => 'moderador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioComentaHistorias()
    {
        return $this->hasMany(UsuarioComentaHistoria::className(), ['historia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDenunciaHistorias()
    {
        return $this->hasMany(UsuarioDenunciaHistoria::className(), ['historia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['username' => 'usuario'])->viaTable('Usuario_denuncia_Historia', ['historia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioReageHistorias()
    {
        return $this->hasMany(UsuarioReageHistoria::className(), ['historia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios0()
    {
        return $this->hasMany(Usuario::className(), ['username' => 'usuario'])->viaTable('Usuario_reage_Historia', ['historia' => 'id']);
    }
}
