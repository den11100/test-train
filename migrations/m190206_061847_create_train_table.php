<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%train}}`.
 */
class m190206_061847_create_train_table extends Migration
{
    public static $tableName = '{{%train}}';
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
            'station_start' => $this->string(255)->notNull(),
            'time_start' => $this->dateTime()->notNull(),
            'station_finish' => $this->string(255)->notNull(),
            'time_finish' => $this->dateTime()->notNull(),
            'travel_time' => $this->integer(11)->notNull(),
            'price' => $this->integer(11)->notNull(),
            'company' => $this->string(255)->notNull(),
            'schedule' => $this->string(255)->notNull()
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
