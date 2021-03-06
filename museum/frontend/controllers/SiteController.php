<?php
namespace frontend\controllers;

use app\models\UsuarioReageHistoria;
use frontend\models\Historia;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\UploadedFile;



/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionDetalhes($id){
        $hist = Historia::findOne($id);
        $idUser = Yii::$app->user->identity->getId();

        // busca no banco se o usuário já reagiu a história, e qual tipo de reação
        $reacao = UsuarioReageHistoria::findOne(['usuario'=>$idUser, 'historia'=>$id]);
        if($reacao){
            $tipo = $reacao->tipo;
        }else{
            $tipo = 0;
        }

        //objeto json que contem informações (detalhes) da história
        $resultado=["titulo"=>$hist->nome, "descricao"=>$hist->descricao, "reacao"=> $tipo];

        // atualiza quantidade de views
        $qteAtual = $hist->qteViews;
        $qteAtual++;
        $sql="UPDATE Historia SET qteViews=$qteAtual WHERE id ='$id'";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();

        return json_encode($resultado);
    }

    public function actionComentar($idHistoria, $comentario){
        //inserir no banco novo comentario
        $idUser = Yii::$app->user->identity->getId();
        $dataHorario = date('Y-m-d H:i:s');

        $sql = "INSERT INTO Usuario_comenta_Historia (usuario, historia, comentario, horario) VALUES ('$idUser', '$idHistoria', '$comentario', '$dataHorario')";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();

        return $sql;
    }

    public function actionDenuncie($idHistoria){
        //inserir no banco novo comentario
        $idUser = Yii::$app->user->identity->getId();

        $historia = Historia::findOne($idHistoria);
        $qteAtual=$historia->qteDenuncias;
        $qteAtual++;

        $sql = "INSERT INTO Usuario_denuncia_Historia (usuario, historia) VALUES ('$idUser', '$idHistoria')";
        $connection = Yii::$app->getDb();

        try{
            // insere na tabela Usuario_reage_historia
            $connection->createCommand($sql)->execute();

            // foi possivel inserir na tabela (ou seja, o usuário ainda não denunciou essa história)
            // a qte de denuncias na história é atualizada
            $sql="UPDATE Historia SET qteDenuncias=$qteAtual WHERE id ='$idHistoria'";
            $connection = Yii::$app->getDb();
            $connection->createCommand($sql)->execute();

        }catch (Exception $e){
            return $e->getMessage();

        }
    }

    public function actionSalvar($idHistoria){
        //inserir no banco novo comentario
        $idUser = Yii::$app->user->identity->getId();

        $sql = "INSERT INTO Usuario_salva_Historia (usuario, historia) VALUES ('$idUser', '$idHistoria')";
        $connection = Yii::$app->getDb();
        try{
        $connection->createCommand($sql)->execute();
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    // no action like e deslike falta adicionar na tabela usuario_reage_historia
    public function actionLike($id){
        $historia = Historia::findOne($id);
        $qteAtual=$historia->qteGostei;
        $qteAtual++;

        $idUser = Yii::$app->user->identity->getId();
        $sql = "INSERT INTO Usuario_reage_Historia (usuario, historia, tipo) VALUES ('$idUser','$id', '1')";
        $connection = Yii::$app->getDb();


        try{
            // insere na tabela Usuario_reage_historia
            $connection->createCommand($sql)->execute();

            // foi possivel inserir na tabela (ou seja, o usuário ainda não curtiu essa história)
            // a qte de likes na história é atualizada
            $sql="UPDATE Historia SET qteGostei=$qteAtual WHERE id ='$id'";
            $connection = Yii::$app->getDb();
            $connection->createCommand($sql)->execute();

        }catch (Exception $e){
            return $e->getMessage();

        }

    }


    public function actionDeslike($id){
        $historia = Historia::findOne($id);
        $qteAtual=$historia->qteNaoGostei;
        $qteAtual++;

        $idUser = Yii::$app->user->identity->getId();

        $sql = "INSERT INTO Usuario_reage_Historia (usuario, historia, tipo) VALUES ('$idUser','$id', '2')";
        $connection = Yii::$app->getDb();

        try{
            // insere na tabela Usuario_reage_historia
            $connection->createCommand($sql)->execute();

            // foi possivel inserir na tabela (ou seja, o usuário ainda não curtiu essa história)
            // a qte de deslikes na história é atualizada
            $sql="UPDATE Historia SET qteNaoGostei=$qteAtual WHERE id ='$id'";
            $connection = Yii::$app->getDb();
            $connection->createCommand($sql)->execute();

        }catch (Exception $e){

        }


    }


    public function actionAprovacao($id){
        //$moderador = Yii::$app->user->identity->getId();
        $moderador = 'moderador1';
        $sql="UPDATE Historia SET status=1, moderador = '$moderador' WHERE id ='$id'";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();
        return $sql;
    }

    public function actionReprovacao($id){
        $sql="UPDATE Historia SET status=2 WHERE id ='$id'";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();

        // esse trecho de código é necessário para que a história com denuncia aceita não apareça mais entre as historias denunciadas
        // no caso de moderação, tanto faz :D
        $sql="UPDATE Historia SET qteDenuncias=0 WHERE id ='$id'";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();


        return $sql;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' =>[
                'class'=> 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client){
        $attributes = $client->getUserAttributes();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return Yii::$app->getResponse()->redirect('http://localhost/redes/museum/frontend/Landing_Page/');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->perfil = UploadedFile::getInstance($model, 'perfil');
            $model->upload();
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
