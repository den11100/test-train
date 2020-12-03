<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $name
 *
 * @property AuthorBook[] $authorBooks
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorBooks()
    {
        return $this->hasMany(AuthorBook::class, ['author_id' => 'id']);
    }
}
