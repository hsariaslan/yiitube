<?php

/**
 * @var yii\web\View $this
 * @var $latestVideo \common\models\Video
 * @var $numberOfViews integer
 * @var $numberOfSubscribers integer
 * @var $lastThreeSubscribers \common\models\Subscriber[]
 */

$this->title = 'My Yii Application';
?>
<div class="site-index d-flex flex-wrap">
    <div class="card m-2" style="width: 14rem;">
        <?php if ($latestVideo): ?>
        <div class="embed-responsive embed-responsive-16by9">
            <video
                    src="<?= $latestVideo->getVideoLink() ?>"
                    class="embed-responsive-item w-100"
                    style="max-height: 350px"
                    poster="<?= $latestVideo->getThumbnailLink() ?>"
            ></video>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $latestVideo->title ?></h5>
            <p class="card-text">
                Likes: <?= $latestVideo->getLikes()->count() ?>
                Views: <?= $latestVideo->getViews()->count() ?>
            </p>
            <a href="<?= \yii\helpers\Url::to(['/video/update', 'video_id' => $latestVideo->video_id]) ?>"
               class="btn btn-primary">Edit</a>
        </div>
        <?php else :?>
        <div class="card-body">You don't have uploaded videos yet.</div>
        <?php endif?>
    </div>
    <div class="card m-2" style="width: 14rem;">
        <div class="card-body">
            <h5 class="card-title">Number of Views</h5>
            <p class="card-text" style="font-size: 48px;">
                <?= $numberOfViews ?>
            </p>
        </div>
    </div>
    <div class="card m-2" style="width: 14rem;">
        <div class="card-body">
            <h5 class="card-title">Number of Subscribers</h5>
            <p class="card-text" style="font-size: 48px;">
                <?= $numberOfSubscribers ?>
            </p>
        </div>
    </div>
    <div class="card m-2" style="width: 14rem;">
        <div class="card-body">
            <h5 class="card-title">Latest Subscribers</h5>
            <p class="card-text">
                <?php foreach ($lastThreeSubscribers as $lastThreeSubscriber): ?>
                <div>
                    <?= $lastThreeSubscriber->user->username ?>
                </div>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
</div>
