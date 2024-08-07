<?php

use yii\bootstrap5\Nav;

?>
<aside class="shadow">
    <?php
    echo Nav::widget([
        'options' => [
            'class' => 'd-flex flex-column nav-pills'
        ],
        'items' => [
            [
                'label' => 'Home',
                'url' => ['/video/index'],
            ],
            [
                'label' => 'History',
                'url' => ['/video/history'],
            ],
        ]
    ])
    ?>
</aside>
