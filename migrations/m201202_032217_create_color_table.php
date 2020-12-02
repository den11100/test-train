<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%color}}`.
 */
class m201202_032217_create_color_table extends Migration
{
    public static $tableName = '{{%color}}';
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
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(20)->notNull(),
        ], $tableOptions);

        $this->insert(self::$tableName, ['name'=>'red']);
        $this->insert(self::$tableName, ['name'=>'green']);
        $this->insert(self::$tableName, ['name'=>'blue']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::$tableName, '');
        $this->dropTable(self::$tableName);
    }
}
