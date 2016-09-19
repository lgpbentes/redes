<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Yii;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $dataNascimento;
    public $cidade;
    public $perfil;
    public $image;
    public $image_bkp;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Esse username já está sendo utilizado'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['dataNascimento'], 'safe'],
            [['cidade'], 'string', 'max' => 30],
            [['perfil'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Esse email já está sendo usado.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->dataNascimento = $this->dataNascimento;
        $user->cidade = $this->cidade;
        $user->perfil = $this->perfil;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    private $nome, $extensao;
    public function upload()
    {
        $nome= "perfil_".$this->username;
        $extensao = $this->perfil->extension;
        if ($this->validate()) {
            $this->perfil->saveAs('img/perfil/' . $nome . '.' . $extensao);
            $this->perfil="img/perfil/".$nome.'.'.$extensao;

            return true;
        } else {
            return false;
        }
    }





}
