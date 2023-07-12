<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%raw_types}}`.
 */
class m230709_105941_create_raw_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%raw_types}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(10)->notNull()->unsigned()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->batchInsert('raw_types', ['name'], [
            ['Шрот'],
            ['Жмых'],
            ['Соя'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%raw_types}}');
    }
}
