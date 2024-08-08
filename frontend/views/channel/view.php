<?php
/**
 * @var $this \yii\web\View
 * @var $channel \common\models\User
 */
?>

<div class="p-5 mb-4 bg-light rounded-3">
    <h1 class="display-4 fw-bold"><?= $channel->username ?></h1>
    <div>
        <?php \yii\widgets\Pjax::begin() ?>

        <?= $this->render('_subscribe', ['channel' => $channel]) ?>

        <?php \yii\widgets\Pjax::end() ?>
    </div>
</div>