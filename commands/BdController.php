<?php

namespace app\commands;
use yii\console\Controller;
class BdController extends Controller
{
    public $message;
    
    public function options($actionID)
    {
        return ['message'];
    }
    
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    public function actionIndex()
    {
        echo $this->message . "\n";
    }
    public function actionSet(){
        // http://bakers.netkama.ru/1C/actions/getcount.php
        // http://bakers.netkama.ru/1C/actions/setcount.php
        
        $mess = '[
{
"id": "c3314aed-6899-11e8-8780-b06ebf2faaf6",
"name": "Стейк Рибай",
"count": 0.5,
"price": 2000
},
{
"id": "79d49858-1fd9-11e9-bd41-74d4357105d2",
"name": "Подложка акрил белая Д24",
"count": 2,
"price": 95.52
}
]';
$username = "admin";
$password = "uBTk06danUe6keR0";  
$curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => "{$username}:{$password}",
        CURLOPT_URL =>'http://bakers.netkama.ru/1C/actions/setcount.php',
        CURLOPT_POST => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POSTFIELDS => $mess,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json']
    )
 );
$resp = curl_exec($curl);
        curl_close($curl);
        var_dump($resp);        
}
    
    
           
}



