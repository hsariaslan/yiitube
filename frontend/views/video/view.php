<?php
/**
 * @var $model \common\models\Video
 * @var $similarVideos \common\models\Video
 */

use yii\helpers\Html;

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
            <div><?= $model->getViews()->count() ?> views
                • <?= Yii::$app->formatter->asDate($model->created_at) ?></div>
            <div>
                <?php \yii\widgets\Pjax::begin() ?>
                <?= $this->render('_like_buttons', ['model' => $model]) ?>
                <?php \yii\widgets\Pjax::end() ?>
            </div>
        </div>
        <div>
            <p><?= \common\helpers\Html::channelLink($model->createdBy) ?></p>
            <p>
                <?= ($model->description)
                    ? Html::encode($model->description)
                    : 'No description.' ?>
            </p>
        </div>
    </div>
    <div class="col-sm-4">
        <?php foreach ($similarVideos as $similarVideo): ?>
            <div class="d-flex mb-3">
                <a href="<?= \yii\helpers\Url::to(['/video/view', 'videoId' => $similarVideo->video_id]) ?>" class="flex-shrink-0">
                    <div class="embed-responsive embed-responsive-16by9" style="width: 160px; height: 90px;">
                        <video
                                src="<?= $similarVideo->getVideoLink() ?>"
                                class="embed-responsive-item w-100 h-100"
                                poster="<?= $similarVideo->getThumbnailLink() ?>"
                        ></video>
                    </div>
                </a>
                <div class="flex-grow-1 ms-3">
                    <h6><?= $similarVideo->title ?></h6>
                    <div>
                        <p class="m-0">
                            <?= \common\helpers\Html::channelLink($similarVideo->createdBy) ?>
                        </p>
                        <small>
                            <?= $similarVideo->getViews()->count() ?> views •
                            <?= Yii::$app->formatter->asRelativeTime($similarVideo->created_at) ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
