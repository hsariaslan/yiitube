<?php
/**
 * @var $channel \common\models\User
 */
?>
<a class="btn <?= $channel->isSubscribed(Yii::$app->user->id) ? 'btn-danger' : 'btn-outline-danger' ?> btn-lg"
   href="<?= \yii\helpers\Url::to(['channel/subscribe', 'username' => $channel->username]) ?>"
   type="button" data-method="post" data-pjax="1">
    <i class="fa-solid fa-bell"></i>
    <span><?= $channel->isSubscribed(Yii::$app->user->id) ? 'Unsubcscribe' : 'Subcscribe' ?></span>
    <span>(<?= $channel->getSubscribers()->count() ?>)</span>
</a>


