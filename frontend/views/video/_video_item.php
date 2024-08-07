<?php
/**
 * @var $model \common\models\Video
 */
?>

<a class="card m-2 text-decoration-none" href="<?= \yii\helpers\Url::to(['/video/view', 'video_id' => $model->video_id]) ?>" style="width: 245px;">
    <div class="embed-responsive embed-responsive-16by9">
        <video
            src="<?= $model->getVideoLink() ?>"
            class="embed-responsive-item w-100"
            style="width: 245px;height: 180px"
            poster="<?= $model->getThumbnailLink() ?>"
        ></video>
    </div>
    <div class="card-body p-2">
        <h5 class="card-title m-0"><?= $model->title ?>></h5>
        <p class="text-muted card-text m-0"><?= $model->createdBy->username ?></p>
        <p class="text-muted card-text m-0"><?= $model->getViews()->count() ?> views • <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>
    </div>
</a>
