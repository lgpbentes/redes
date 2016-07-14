<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Usuario".
 *
 * @property string $username
 * @property string $senha
 * @property string $dataNascimento
 * @property string $cidade
 * @property string $keyfb
 * @property string $keygplus
 *
 * @property Historia[] $historias
 * @property UsuarioComentaHistoria[] $usuarioComentaHistorias
 * @property UsuarioDenunciaHistoria[] $usuarioDenunciaHistorias
 * @property Historia[] $historias0
 * @property UsuarioReageHistoria[] $usuarioReageHistorias
 * @property Historia[] $historias1
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['dataNascimento'], 'safe'],
            [['keyfb', 'keygplus'], 'string'],
            [['username'], 'string', 'max' => 20],
            [['senha'], 'string', 'max' => 10],
            [['cidade'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'senha' => 'Senha',
            'dataNascimento' => 'Data de Nascimento',
            'cidade' => 'Cidade',
            'keyfb' => 'Keyfb',
            'keygplus' => 'Keygplus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorias()
    {
        return $this->hasMany(Historia::className(), ['autor' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioComentaHistorias()
    {
        return $this->hasMany(UsuarioComentaHistoria::className(), ['usuario' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioDenunciaHistorias()
    {
        return $this->hasMany(UsuarioDenunciaHistoria::className(), ['usuario' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorias0()
    {
        return $this->hasMany(Historia::className(), ['id' => 'historia'])->viaTable('Usuario_denuncia_Historia', ['usuario' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioReageHistorias()
    {
        return $this->hasMany(UsuarioReageHistoria::className(), ['usuario' => 'username']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorias1()
    {
        return $this->hasMany(Historia::className(), ['id' => 'historia'])->viaTable('Usuario_reage_Historia', ['usuario' => 'username']);
    }
}
