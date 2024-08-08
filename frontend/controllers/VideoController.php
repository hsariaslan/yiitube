<?php

namespace frontend\controllers;

use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class VideoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike', 'history'],
                'rules' => [[
                    'allow' => true,
                    'roles' => ['@']
                ]]
            ],
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post']
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->published()->latest(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findVideo($videoId)
    {
        $video = Video::findOne($videoId);

        if (!$video) {
            throw new NotFoundHttpException();
        }

        return $video;
    }

    public function actionView($videoId)
    {
        $this->layout = 'view';
        $video = $this->findVideo($videoId);

        $videoView = new VideoView();
        $videoView->video_id = $videoId;
        $videoView->user_id = Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        $similarVideos = Video::find()->published()->byKeyword($video->title)->andWhere(['NOT', ['video_id' => $videoId]])->limit(10)->all();

        return $this->render('view', [
            'model' => $video,
            'similarVideos' => $similarVideos,
        ]);
    }

    public function actionSearch($keyword)
    {
        $query = Video::find()->published()->latest();

        if ($keyword) {
            $query->byKeyword($keyword);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('search', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHistory()
    {
        $query = Video::find()
        ->alias('v')
        ->innerJoin("(SELECT video_id, MAX(created_at) as max_date
        FROM video_view
        WHERE user_id = :userId
        GROUP BY video_id) vv", 'vv.video_id = v.video_id', [
            'userId' => Yii::$app->user->id,
        ])
        ->orderBy('vv.max_date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLike($videoId)
    {
        $this->layout = 'view';
        $video = $this->findVideo($videoId);

        $userId = Yii::$app->user->id;
        $videoLikeOrDislike = VideoLike::find()->byVideoIdAndUserId($videoId, $userId)->one();

        if (!$videoLikeOrDislike) {
            $this->saveLike($videoId, $userId);
        } else if ($videoLikeOrDislike->type == VideoLike::TYPE_LIKE) {
            $videoLikeOrDislike->delete();
        } else {
            $videoLikeOrDislike->delete();
            $this->saveLike($videoId, $userId);
        }

        return $this->renderAjax('_like_buttons', [
            'model' => $video,
        ]);
    }

    public function actionDislike($videoId)
    {
        $this->layout = 'view';
        $video = $this->findVideo($videoId);

        $userId = Yii::$app->user->id;
        $videoLikeOrDislike = VideoLike::find()->byVideoIdAndUserId($videoId, $userId)->one();

        if (!$videoLikeOrDislike) {
            $this->saveDislike($videoId, $userId);
        } else if ($videoLikeOrDislike->type == VideoLike::TYPE_DISLIKE) {
            $videoLikeOrDislike->delete();
        } else {
            $videoLikeOrDislike->delete();
            $this->saveDislike($videoId, $userId);
        }

        return $this->renderAjax('_like_buttons', [
            'model' => $video,
        ]);
    }

    protected function saveLike($videoId, $userId)
    {
        $this->saveLikeOrDislike($videoId, $userId, VideoLike::TYPE_LIKE);
    }

    protected function saveDisLike($videoId, $userId)
    {
        $this->saveLikeOrDislike($videoId, $userId, VideoLike::TYPE_DISLIKE);
    }

    protected function saveLikeOrDislike($videoId, $userId, $type)
    {
        $videoLikeOrDislike = new VideoLike();
        $videoLikeOrDislike->video_id = $videoId;
        $videoLikeOrDislike->user_id = $userId;
        $videoLikeOrDislike->created_at = time();
        $videoLikeOrDislike->type = $type;
        $videoLikeOrDislike->save();
    }
}