<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history}}`.
 */
class m230730_213648_create_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull(),
            'username' => $this->string(50)->notNull(),
            'tonnage' => $this->tinyInteger(3)->notNull(),
            'month' => $this->string(15)->notNull(),
            'raw_type' => $this->string(15)->notNull(),
            'price' => $this->integer(3)->notNull(),
            'snapshot' => $this->json()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history}}');
    }
}
