<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Usuario_denuncia_Historia".
 *
 * @property integer $usuario
 * @property integer $historia
 *
 * @property Historia $historia0
 * @property User $usuario0
 */
class UsuarioDenunciaHistoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuario_denuncia_Historia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario', 'historia'], 'required'],
            [['usuario', 'historia'], 'integer'],
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
