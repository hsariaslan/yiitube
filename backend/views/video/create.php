<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Video $model */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="upload-icon">
            <i class="fa-solid fa-upload"></i>
        </div>
        <p class="m-0 mt-4">Video dosyalarını yüklemek için sürükleyin ve bırakın</p>
        <p class="text-muted">Videolarınız, siz yayınlayana kadar gizli olarak kalır.</p>

        <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
        ]); ?>

        <?= $form->errorSummary($model) ?>

        <button class="btn btn-primary btn-file">
            Select File
            <input type="file" id="uploadFile" name="video">
        </button>
        <?php ActiveForm::end(); ?>
    </div>

</div>
