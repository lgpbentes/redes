<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Usuario_reage_Historia".
 *
 * @property integer $usuario
 * @property integer $historia
 * @property integer $tipo
 *
 * @property Historia $historia0
 * @property User $usuario0
 */
class UsuarioReageHistoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuario_reage_Historia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'historia'], 'required'],
            [['usuario', 'historia', 'tipo'], 'integer'],
            [['historia'], 'exist', 'skipOnError' => true, 'targetClass' => Historia::className(), 'targetAttribute' => ['historia' => 'id']],
            [['usuario'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usuario' => 'Usuario',
            'historia' => 'Historia',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistoria0()
    {
        return $this->hasOne(Historia::className(), ['id' => 'historia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario0()
    {
        return $this->hasOne(User::className(), ['id' => 'usuario']);
    }
}
