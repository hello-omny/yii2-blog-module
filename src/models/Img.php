<?php

namespace omny\yii2\blog\module\models;

use omny\yii2\blog\module\query\ImgQuery;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * Class Img
 * @package omny\yii2\blog\module\models
 *
 * @property string $filename
 * @property string $updated
 * @property string $created
 * @property string $alt
 * @property string $title
 */
class Img extends ActiveRecord
{
    /** @var UploadedFile */
    public $image;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'img';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['filename'], 'required'],
            [['updated', 'created'], 'safe'],
            [['filename', 'alt', 'title'], 'string', 'max' => 255],
            [['filename'], 'unique'],

            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'alt' => 'Alt',
            'title' => 'Title',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'updated'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated'],
                ],

                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * @inheritdoc
     * @return ImgQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ImgQuery(get_called_class());
    }

    /**
     * @param string $folder
     * @return bool
     * @throws Exception
     */
    public function uploadImage($folder = ''): bool
    {
        if (empty($this->image)) {
            return false;
        }

        $this->image = UploadedFile::getInstance($this, 'image');
        if ($this->image === null) {
            throw new Exception('Uploaded file instance not exist.');
        }

        $uploadPath = $this->getUploadPath($folder);
        $viewPath = $this->getViewPath($folder);
        $fileName = $this->getFileName();

        if (file_exists(sprintf('%s/%s', $uploadPath, $fileName))) {
            $fileName = $this->getFileName(\Yii::$app->security->generateRandomString(7));
        }

        $this->filename = sprintf('%s/%s', $viewPath, $fileName);
        if (!$this->validate()) {
            throw new Exception(sprintf('Uploading file not valid. %s', print_r($this->errors, true)));
        }

        if (!$this->save()) {
            throw new Exception('Failed save model.');
        }
        if (!$this->image->saveAs(sprintf('%s/%s', $uploadPath, $fileName))) {
            throw new Exception('Move uploaded file fail.');
        }

        return true;
    }

    /**
     * Return stored img url if it setup and if not return default.png, stored in /web/img/default.png
     *
     * @param $model
     * @param bool $default
     * @param null $folder
     * @return null|string
     */
    public static function getUrl($model, $default = true, $folder = null)
    {
        $defaultPath = \Yii::getAlias('@web');
        $path = $folder ?
            $defaultPath . $folder . "/" :
            $defaultPath;

        if (is_null($model)) {
            return $default ? Url::to($defaultPath . '/img/' . 'default.png', true) : null;
        }
        $path = $path . $model->filename;

        return Url::to($path, true);
    }

    /**
     * @return string
     */
    public function getViewUrl(): string
    {
        return Url::to($this->filename, true);
    }

    /**
     * fetch stored image file name with complete path
     * @param string $folder ;
     * @return string
     */
    public function getImageFile($folder = false)
    {
        $defaultPath = \Yii::getAlias('@web');
        $path = $folder ? $defaultPath . "/" . $folder : $defaultPath;

        return isset($this->filename) ? $path . "/" . $this->filename : null;
    }

    /**
     * @param int $userId
     * @param int $postId
     * @return string
     */
    public function generatePath(int $userId, int $postId): string
    {
        return sprintf('%d/%d', $userId, $postId);
    }

    /**
     * Process deletion of image
     * @param string|bool $folder
     * @return bool
     */
    public function deleteImage($folder = false)
    {
        $file = $this->getImageFile($folder);

        if (empty($file) || !file_exists($file)) {
            return false;
        }

        if (!unlink($file)) {
            return false;
        }

        $this->filename = null;

        return true;
    }

    /**
     * Setup default image
     *
     * @param string $filename
     * @param string $folder
     * @return string
     */
    public static function defaultImg($filename = 'default.png', $folder = 'i')
    {
        $defaultPath = \Yii::getAlias('@web');

        $full_path = $folder ?
            $defaultPath . "/" . $folder . "/" . $filename :
            $defaultPath . "/" . $filename;

        return $full_path;
    }

    /**
     * @param string|null $suffix
     * @return string
     */
    private function getFileName(string $suffix = null): string
    {
        if ($suffix !== null) {
            return sprintf('%s_%s.%s', $this->image->baseName, $suffix, $this->image->extension);
        }
        return sprintf('%s.%s', $this->image->baseName, $this->image->extension);
    }

    /**
     * @param string $folder
     * @return string
     */
    private function getViewPath(string $folder): string
    {
        $viewPath = \Yii::getAlias(sprintf('@web/upload/%s', $folder));

        return $viewPath;
    }

    /**
     * @param string $folder
     * @return string
     * @throws Exception
     */
    private function getUploadPath(string $folder): string
    {
        $uploadPath = \Yii::getAlias(sprintf('@webroot/upload/%s', $folder));

        if (FileHelper::createDirectory($uploadPath)) {
            return $uploadPath;
        };

        throw new Exception("Can't create directory");
    }
}