<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'TEST-TASKS';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Trains schedule</h2>
                <p><a class="btn btn-default" href="<?= Url::to("/train/index") ?>">Trains schedule</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Balance charts</h2>
                <p><a class="btn btn-default" href="<?= Url::to("/file/index") ?>">Balance chart</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Coda</h2>
                <p><a class="btn btn-default" href="<?= Url::to("/coda/start") ?>">Coda</a></p>
            </div>
        </div>

    </div>
</div>
