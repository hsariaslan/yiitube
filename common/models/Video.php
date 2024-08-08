<?php

namespace common\models;

use Imagine\Image\Box;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\FileHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property int|null $created_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var \yii\web\UploadedFile
     */
    public $video;

    /**
     * @var \yii\web\UploadedFile
     */
    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_by', 'created_at', 'updated_at'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 255],
            [['tags'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            ['status', 'default', 'value' => self::STATUS_UNLISTED],
            ['has_thumbnail', 'default', 'value' => 0],
            ['thumbnail', 'image', 'minWidth' => 320, 'minHeight' => 180],
            ['video', 'file', 'extensions' => ['mp4']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Has Thumbnail',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'thumbnail' => 'Thumbnail',
        ];
    }

    public function getStatusLabels()
    {
        return [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function isLikedBy($userId)
    {
        return VideoLike::find()->byLike()->byVideoIdAndUserId($this->video_id, $userId)->one();
    }

    public function isDislikedBy($userId)
    {
        return VideoLike::find()->byDislike()->byVideoIdAndUserId($this->video_id, $userId)->one();
    }

    public function getViews(): ActiveQuery
    {
        return $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }

    public function getLikes(): ActiveQuery
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])->byLike();
    }

    public function getDislikes(): ActiveQuery
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])->byDislike();
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null): bool
    {
        $isInsert = $this->isNewRecord;

        if ($isInsert) {
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
        }

        if ($this->thumbnail) {
            $this->has_thumbnail = 1;
        }

        $isSaved = parent::save($runValidation, $attributeNames);

        if (!$isSaved) {
            return false;
        }

        if ($isInsert) {
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');

            if (!is_dir(dirname($videoPath))) {
                FileHelper::createDirectory(dirname($videoPath));
            }

            $saveAsVideo = $this->video->saveAs($videoPath);

            if (!$saveAsVideo) {
                return false;
            }
        }

        if ($this->thumbnail) {
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbnails/' . $this->video_id . '.jpg');

            if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }

            $this->thumbnail->saveAs($thumbnailPath);

            Image::getImagine()
                ->open($thumbnailPath)
                ->thumbnail(new Box(320, 180))
                ->save();
        }

        return true;
    }

    public function afterDelete(): void
    {
        parent::afterDelete();

        $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');
        $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbnails/' . $this->video_id . '.jpg');

        if (file_exists($videoPath)) {
            unlink($videoPath);
        }

        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }

    public function getVideoLink()
    {
        return Yii::$app->params['frontendUrl'].'/storage/videos/' . $this->video_id . '.mp4';
    }

    public function getThumbnailLink()
    {
        return Yii::$app->params['frontendUrl'].'/storage/thumbnails/' . $this->video_id . '.jpg';
    }
}
