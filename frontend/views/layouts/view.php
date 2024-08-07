<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginContent('@frontend/views/layouts/base.php') ?>
    <main role="main" class="d-flex mt-5">
        <div class="content-wrapper p-3">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
<?php $this->endContent(); ?>