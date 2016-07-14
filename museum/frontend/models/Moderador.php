<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "Moderador".
 *
 * @property string $login
 * @property string $senha
 *
 * @property Historia[] $historias
 */
class Moderador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Moderador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login'], 'required'],
            [['login'], 'string', 'max' => 20],
            [['senha'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Login',
            'senha' => 'Senha',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistorias()
    {
        return $this->hasMany(Historia::className(), ['moderador' => 'login']);
    }
}
