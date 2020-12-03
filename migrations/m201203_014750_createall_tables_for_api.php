<?php

use yii\db\Migration;

/**
 * Class m201203_014750_createall_tables_for_api
 */
class m201203_014750_createall_tables_for_api extends Migration
{
    public $tableAuthor = '{{%author}}';
    public $tableBook = '{{%book}}';
    public $tableAuthorBook = '{{%author_book}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableAuthor, [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
        ], $tableOptions);

        $this->createTable($this->tableBook, [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->notNull(),
        ], $tableOptions);

        $this->createTable($this->tableAuthorBook, [
            'author_id' => $this->integer(11)->notNull(),
            'book_id' => $this->integer(11)->notNull(),
        ], $tableOptions);


        $this->addForeignKey(
            'author-book_to_author',
            $this->tableAuthorBook,
            'author_id',
            $this->tableAuthor,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'author-book_to_book',
            $this->tableAuthorBook,
            'book_id',
            $this->tableBook,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->insert($this->tableBook, ['name'=>'1984']);
        $this->insert($this->tableBook, ['name'=>'Скотный двор']);
        $this->insert($this->tableBook, ['name'=>'Оккультизм и сексуальность']);

        $this->insert($this->tableAuthor, ['name'=>'Джордж Оруэлл ']);
        $this->insert($this->tableAuthor, ['name'=>'Ганс Фреймарк']);

        $this->insert($this->tableAuthorBook, ['author_id'=> 1, 'book_id' =>1]);
        $this->insert($this->tableAuthorBook, ['author_id'=> 1, 'book_id' =>2]);
        $this->insert($this->tableAuthorBook, ['author_id'=> 2, 'book_id' =>3]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('author-book_to_book', $this->tableAuthorBook);
        $this->dropForeignKey('author-book_to_author', $this->tableAuthorBook);
        $this->dropTable($this->tableAuthorBook);
        $this->dropTable($this->tableBook);
        $this->dropTable($this->tableAuthor);
    }
}
