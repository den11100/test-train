<?php


namespace app\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property string $series_data
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $uploadFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'integer'],
            [['series_data'], 'string'],
            [['uploadFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'html'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'status' => 'Статус',
            'uploadFile' => 'Загрузить файл',
        ];
    }

    public function upload()
    {
        $name = uniqid() ."-". $this->uploadFile->baseName . '.' . $this->uploadFile->extension;
        $this->name = $name;
        if ($this->validate()) {
            $this->uploadFile->saveAs(Yii::getAlias('@app').'/uploads/'.$name);
            $this->save(false);
            return $this;
        } else {
            return false;
        }
    }
}