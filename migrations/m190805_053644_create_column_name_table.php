<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%column_name}}`.
 */
class m190805_053644_create_column_name_table extends Migration
{
    public static $tableName = '{{%column_name}}';
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
            'is_active' => $this->integer()->defaultValue(0),
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
