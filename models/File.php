<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class File extends Model
{
    /**
     * @var UploadedFile
     */
    public $uploadFile;

    public function rules()
    {
        return [
            [['uploadFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'html'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->uploadFile->saveAs(Yii::getAlias('@app').'/uploads/' . $this->uploadFile->baseName . '.' . $this->uploadFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $file
     * @return string
     */
    public static function getFileName($files)
    {
        $result = [];
        foreach ($files as $file) {
            $array = explode('/', $file);
            $result[] = array_pop( $array);
        }
        return $result;
    }
}