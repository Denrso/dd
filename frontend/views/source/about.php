<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Текущий курс Евро';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h3>КУРС ЕВРО НА СЕГОДНЯ</h3>

<? //print_r($data)?>

    <div class="container-fluid">
        <div class="row">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                     style="width: 0;">
                    <span class="sr-only">0% Complete</span>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered result">
                    <thead>
                    <th>Евро/Рубль</th>
                    <th>Единиц</th>
                    <th>Результат</th>
                    <th>Источник</th>
                    </thead>
                    <tbody>
                    <? foreach ($data as $d) {
                        echo '<tr><td><i class="glyphicon glyphicon-euro"></i> </td><td>1</td><td><b>' . $d["currency"] . '</b><i class="glyphicon glyphicon-ruble"></i></td><td>' . $d["url"] . '</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
            </div>
        </div>
    </div>

    <? $this->registerJsFile('@web/js/getdata.js',  ['depends' => [\yii\web\JqueryAsset::className()]]); ?>


</div>
