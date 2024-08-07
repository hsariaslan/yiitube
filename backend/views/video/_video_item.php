<?php
/**
 * @var $model \common\models\Video
 */
?>
<div class="d-flex align-items-center">
    <div class="flex-shrink-0">
        <a href="<?= \yii\helpers\Url::to(['/video/update', 'video_id' => $model->video_id]) ?>">
            <div class="embed-responsive embed-responsive-16by9">
                <video
                        src="<?= $model->getVideoLink() ?>"
                        class="embed-responsive-item"
                        style="width: 160px; height: 90px;"
                        poster="<?= $model->getThumbnailLink() ?>"
                ></video>
            </div>
        </a>
    </div>
    <div class="flex-grow-1 ms-3">
        <h6><?= $model->title ?></h6>
        <?= \yii\helpers\StringHelper::truncateWords($model->description, 10) ?>
    </div>
</div>
