<?php
/**
 * @var $model \common\models\Video
 */
?>
<a href="<?= \yii\helpers\Url::to(['/video/like', 'videoId' => $model->video_id]) ?>"
   class="btn btn-sm btn-outline-<?= ($model->isLikedBy(Yii::$app->user->id) ? 'primary' : 'secondary') ?>"
   data-method="post" data-pjax="1">
    <i class="fa-solid fa-thumbs-up"></i>
    <?= $model->getLikes()->count() ?>
</a>

<a href="<?= \yii\helpers\Url::to(['/video/dislike', 'videoId' => $model->video_id]) ?>"
   class="btn btn-sm btn-outline-<?= ($model->isDislikedBy(Yii::$app->user->id) ? 'primary' : 'secondary') ?>"
   data-method="post" data-pjax="1">
    <i class="fa-solid fa-thumbs-down"></i>
    <?= $model->getDislikes()->count() ?>
</a>
