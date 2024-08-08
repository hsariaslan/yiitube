<?php
/**
 * @var $model \common\models\Video
 */
?>

<div class="card m-2" style="width: 245px;">
    <a class="text-decoration-none" href="<?= \yii\helpers\Url::to(['/video/view', 'videoId' => $model->video_id]) ?>">
        <div class="embed-responsive embed-responsive-16by9">
            <video
                src="<?= $model->getVideoLink() ?>"
                class="embed-responsive-item w-100"
                style="width: 245px;height: 180px"
                poster="<?= $model->getThumbnailLink() ?>"
            ></video>
        </div>
    </a>
    <div class="card-body p-2">
        <h5 class="card-title m-0"><?= $model->title ?></h5>
        <p class="text-muted card-text m-0">
            <?= \common\helpers\Html::channelLink($model->createdBy) ?>
        </p>
        <p class="text-muted card-text m-0"><?= $model->getViews()->count() ?> views • <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></p>
    </div>
</div>
