<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%file}}`.
 */
class m190710_092543_create_file_table extends Migration
{
    public static $tableName = '{{%file}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::$tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'series_data' => $this->text()->defaultValue(null),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::$tableName);
    }
}
