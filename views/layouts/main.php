<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="fixed-top text-center p-3 mb-2 bg-secondary text-white" style="top:0; left:0;">
        <form class="form-inline">
            <label for="inputMessage" style="margin-right: 10px;"><?=$this->title?>:</label>
            <input style="width:40%; margin-right: 10px;" type="text" class="form-control" id="inputMessage" placeholder="место для вашего сообщения"> 
            <button STYLE="margin-right:10px;" type="submit" class="btn btn-primary mb-2">>></button>
            
            <small id="inputMessageHelp" class="form-text text-muted text-white-50">Обновление, каждые 5 сек.</small>
            <input id='nom' value="0" type="hidden">
            
        </form>
    </div>


    <div class="container" style="margin-top: 50px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div id = 'viewp'>
            
        </div><?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="float-left"><?=$this->title?>  <?= date('Y') ?>  </div>
        <div class="float-right"><?= Yii::powered() ?></div>
    </div>
</footer>
<?php
$js = <<<JS
   var myTime;
   $.fn.view = function(auto=false) {
    $.ajax({
         url: '/messages/get',
         type: 'GET',
         data: {key:$('#nom').val()},
         success: function(res){            
             if(res.error){
                 Swal.fire({
                     icon: 'error',
                     title: 'Опаньки!',
                     text: res['data'],
                     footer: 'Разработка сайтов: Симонов Дмитрий'
                 })
             }else{                
                 $(res.data).each(function(i,dat){
                    tx = '<div class="card my-2"><div class="card-body"><span class="badge badge-pill badge-info mr-3 p-2 float-left">IP:' + dat.ip + '</span>' + dat.message + '</div></div>';
                    if(auto) $("#viewp").append(tx);
                    else $("#viewp").prepend(tx);
                if(dat.id>$('#nom').val())$('#nom').val(dat.id);
                $('#inputMessage').val('');
                });
             }
         },
         error: function(){
             Swal.fire({
                 icon: 'error',
                 title: 'Опаньки!',
                 text: 'Что-то пошло ни так!',
                 footer: 'Разработка сайтов: Симонов Дмитрий'
             })
         }
     });
        myTime = setTimeout(function(){ $(this).view(); }, 5000);
   }; 
        
        
$(document).ready(function() {
    $(this).view(true)
}); 
    
 
 $('form').submit(function(){
    clearTimeout(myTime);
    $.ajax({
        url: '/messages/set',
        type: 'GET',
        data: {message:$("#inputMessage").val()},
        success: function(res){
            if(res.error){
                Swal.fire({
                    icon: 'error',
                    title: 'Опаньки!',
                    text: res['data'],
                    footer: 'Разработка сайтов: Симонов Дмитрий'
                })
            }else{
                $(this).view();
              };
        },
        error: function(){
            Swal.fire({
                icon: 'error',
                title: 'Опаньки!',
                text: 'Что-то пошло ни так!',
                footer: 'Разработка сайтов: Симонов Дмитрий'
            })
        }
    });
    return false;
 });
JS;

$this->registerJs($js);
?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
