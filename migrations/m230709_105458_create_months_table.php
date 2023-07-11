<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%months}}`.
 */
class m230709_105458_create_months_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%months}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(10)->notNull()->unsigned()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%months}}');
    }
}
