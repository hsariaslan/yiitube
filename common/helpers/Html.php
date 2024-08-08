<?php

namespace common\helpers;

use yii\helpers\Url;

class Html
{
    public static function channelLink($user, $scheme = false)
    {
        return \yii\helpers\Html::a($user->username,
            Url::to(['channel/view', 'username' => $user->username], $scheme),
            ['class' => 'text-dark text-decoration-none']);
    }
}