<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Video $model */
/** @var yii\bootstrap5\ActiveForm $form */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-sm-8">
            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group mb-3">
                <label for="thumbnail"><?= $model->getAttributeLabel('thumbnail') ?></label>
                <input type="file" class="form-control" id="thumbnail" name="thumbnail">
            </div>

            <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <div class="mb-3">
                <div class="embed-responsive embed-responsive-16by9">
                    <video
                            src="<?= $model->getVideoLink() ?>"
                            class="embed-responsive-item w-100"
                            controls
                            style="max-height: 350px"
                            poster="<?= $model->getThumbnailLink() ?>"
                    ></video>
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted">Video Link</div>
                <a href="<?= $model->getVideoLink() ?>" target="_blank">
                    <?= $model->getVideoLink() ?>
                </a>
            </div>

            <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
