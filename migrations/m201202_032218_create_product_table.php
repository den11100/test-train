<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m201202_032218_create_product_table extends Migration
{
    public static $tableName = '{{%product}}';
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
            'name' => $this->string(255),
            'price' => $this->float()->defaultValue('0.00'),
            'color_id' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->insert(self::$tableName, ['name' =>'Товар 1','price'=>'100.00','color_id'=> 1]);
        $this->insert(self::$tableName, ['name' =>'Товар 2','price'=>'150.00','color_id'=> 1]);
        $this->insert(self::$tableName, ['name' =>'Товар 3','price'=>'50.00','color_id'=> 2]);
        $this->insert(self::$tableName, ['name' =>'Товар 4','price'=>'300.00','color_id'=> 2]);
        $this->insert(self::$tableName, ['name' =>'Товар 5','price'=>'400.00','color_id'=> 3]);
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
