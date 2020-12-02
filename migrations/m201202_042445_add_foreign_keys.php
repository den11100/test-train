<?php

use yii\db\Migration;

/**
 * Class m201202_042445_add_foreign_keys
 */
class m201202_042445_add_foreign_keys extends Migration
{

    public $tableColor = '{{%color}}';
    public $tableProduct = '{{%product}}';
    public $tablePercent = '{{%percent}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'product_to_color',
            $this->tableProduct,
            'color_id',
            $this->tableColor,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'percent_to_color',
            $this->tablePercent,
            'color_id',
            $this->tableColor,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('percent_to_color', $this->tablePercent);
        $this->dropForeignKey('product_to_color', $this->tableProduct);
    }
}
