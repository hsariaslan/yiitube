<?php
/**
 * @var $model \common\models\Video
 */
?>

<div class="row">
    <div class="col-sm-8">
        <div class="embed-responsive embed-responsive-16by9">
            <video
                src="<?= $model->getVideoLink() ?>"
                class="embed-responsive-item w-100"
                poster="<?= $model->getThumbnailLink() ?>"
                controls
            ></video>
        </div>
        <h6 class="mt-2"><?= $model->title ?></h6>
        <div class="d-flex justify-content-between align-items-center">
            <div><?= $model->getViews()->count() ?> views • <?= Yii::$app->formatter->asDate($model->created_at) ?></div>
            <div>
                <?php \yii\widgets\Pjax::begin() ?>
                <?= $this->render('_like_buttons', ['model' => $model]) ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
