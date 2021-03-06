<?php

namespace frontend\models;

use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use common\models\User;

/**
 * This is the model class for table "Historia".
 *
 * @property string $id
 * @property boolean $anonima
 * @property int $autor
 * @property string $nome
 * @property string $imagem
 * @property string $descricao
 * @property string $qteViews
 * @property integer $qteGostei
 * @property integer $qteNaoGostei
 * @property integer $qteDenuncias
 * @property integer $duracao
 * @property integer $status
 * @property string $moderador
 *
 * @property User $autor0
 * @property Moderador $moderador0
 * @property UsuarioComentaHistoria[] $usuarioComentaHistorias
 * @property UsuarioDenunciaHistoria[] $usuarioDenunciaHistorias
 * @property User[] $usuarios
 * @property UsuarioReageHistoria[] $usuarioReageHistorias
 * @property User[] $usuarios0
 */

class Historia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $crop_info;
    public $image;
    public $image_bkp;

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
            [['descricao', 'duracao', 'imagem'], 'required'],
            ['anonima', 'boolean'],
            [['imagem'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['descricao'], 'string'],
            [['qteGostei', 'qteNaoGostei', 'qteDenuncias', 'duracao', 'status'], 'integer'],
            [['id'], 'string', 'max' => 6],
            [['autor', 'moderador'], 'string', 'max' => 20],
            [['nome'],'string', 'max'=>35],
            [['autor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['autor' => 'id']],
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
            'anonima' => 'Deseja manter anônima?',
            'autor' => 'Autor',
            'nome' => 'Título',
            'imagem' => 'Imagem',
            'descricao' => 'Descrição',
            'qteViews' => "Qte Views",
            'qteGostei' => 'Qte Gostei',
            'qteNaoGostei' => 'Qte Nao Gostei',
            'qteDenuncias' => 'Qte Denuncias',
            'duracao' => 'Duração',
            'status' => 'Status',
            'moderador' => 'Moderador',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor0()
    {
        return $this->hasOne(User::className(), ['id' => 'autor']);
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
        return $this->hasMany(User::className(), ['id' => 'usuario'])->viaTable('Usuario_denuncia_Historia', ['historia' => 'id']);
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
        return $this->hasMany(User::className(), ['id' => 'usuario'])->viaTable('Usuario_reage_Historia', ['historia' => 'id']);
    }

    private $nome, $extensao;
    public function upload()
    {
        $nome= "imagem_tmp";
        $extensao = $this->imagem->extension;
        if ($this->validate()) {
            $this->imagem->saveAs('images/' . $nome . '.' . $extensao);
            $this->imagem="images/".$nome.'.'.$extensao;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // open image
        $image = Image::getImagine()->open($this->imagem);

        //delete old images
        $oldImages = FileHelper::findFiles(Yii::getAlias('images'), [
            'only' => [
                $this->imagem
            ],
        ]);
        for ($i = 0; $i != count($oldImages); $i++) {
            @unlink($oldImages[$i]);
        }


        $pathThumbImage = Yii::getAlias('images')
            . '/publicacao_'
            . $this->id
            . '.jpg';

        $this->imagem='images/'.'publicacao_'.$this->id;
        $this->image_bkp='images/'.'publicacao_'.$this->id;

        $urlImagem = 'images/'.'publicacao_'.$this->id . '.jpg';
        $meuid= $this->id;
        $command = Yii::$app->db->createCommand("UPDATE Historia SET imagem='$urlImagem' WHERE id='$meuid'");

        $command->execute();

        $image->save($pathThumbImage, ['quality' => 100]);
    }


}
