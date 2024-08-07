<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function actionView(string $username)
    {
        $channel = $this->findChannel($username);

        return $this->render('view', [
            'channel' => $channel,
        ]);
    }

    protected function findChannel(string $username)
    {
        $channel = User::findByUsername($username);

        if (!$channel) {
            throw new NotFoundHttpException("Channel does not exist");
        }

        return $channel;
    }
}