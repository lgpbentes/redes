<?php
namespace frontend\controllers;

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

/**
 * Site controller
 */
class SiteController extends Controller
{


    public function actionDetalhes($id){

        $hist = Historia::findOne($id);
        $resultado=["titulo"=>$hist->nome, "descricao"=>$hist->descricao];

        $qteAtual = $hist->qteViews;
        $qteAtual++;
        $sql="UPDATE Historia SET qteViews=$qteAtual WHERE id ='$id'";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();

        return json_encode($resultado);
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

        $sql="UPDATE Historia SET status=1 WHERE id ='$id'";
        $connection = Yii::$app->getDb();
        $connection->createCommand($sql)->execute();
        return $sql;
    }

    public function actionReprovacao($id){

        $sql="UPDATE Historia SET status=2 WHERE id ='$id'";
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
        ];
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
