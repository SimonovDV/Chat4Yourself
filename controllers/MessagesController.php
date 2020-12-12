<?php

namespace app\controllers;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Messages;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class MessagesController extends Controller
{
    /**
     * Ограничения на контроллер
     */
    public function behaviors()
    {
        $method[] = 'post';
//        if(YII_ENV_DEV) $method[] = 'get';
        $method[] = 'get';
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'set' => $method,
                    'get' => $method,
                ],
            ]
        ];
    }
     
    
    public function actionSet($message)
    {
        $model = new Messages(); // Создаём экземпляр модели.    
        // Устанавливаем формат ответа JSON
         Yii::$app->response->format = Response::FORMAT_JSON;
        // Если пришёл AJAX запрос
        if(Yii::$app->request->isAjax || YII_ENV_DEV) {
            //$data = Yii::$app->request->get();
            $model->message = $message;            
            // Получаем данные модели из запроса
            if($model->save()) {
                //Если всё успешно, отправляем ответ с данными
                return [
                    "data" => $model,
                    "error" => false
                    ];
            } else {
                // Если нет, отправляем ответ с сообщением об ошибке
                return [
                    "data" => "Не могу сохранить данные",
                    "error" => true
                ];
            }
        } else {
            // Если это не AJAX запрос, отправляем ответ с сообщением об ошибке
            Yii::$app->response->setStatusCode(404);
            exit();
        }
        return [
            "data" => "Ошибка вызоваы",
            "error" => true
            ];
    }

    public function actionGet($key=0)
    {
        // Устанавливаем формат ответа JSON
        Yii::$app->response->format = Response::FORMAT_JSON;
        $ret = [];
        // Если пришёл AJAX запрос
        if(Yii::$app->request->isAjax || YII_ENV_DEV) {
            foreach(Messages::find()->where([">","id",$key])->orderBy("id DESC")->limit(10)->all() as $NextMessage){
                $ret[]= ['id'=>$NextMessage->id,'message'=>$NextMessage->message,'ip'=>long2ip($NextMessage->ip)];                
            }
        }
        return ["data"=>$ret,"error"=>false];
        
    }
              
}
