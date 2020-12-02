<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%percent}}`.
 */
class m201202_041416_create_percent_table extends Migration
{
    public static $tableName = '{{%percent}}';
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
            'color_id' => $this->primaryKey()->unsigned(),
            'value' => $this->smallInteger(),
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
