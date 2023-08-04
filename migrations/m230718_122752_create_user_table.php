<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m230718_122752_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(100)->notNull(),
            'password' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull()->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->batchInsert('{{%user}}', ['username', 'email', 'password'], [
            ['Администратор', 'administrator1@gmail.com', Yii::$app->security->generatePasswordHash('administrator1')],
            ['Пользователь', 'user123@gmail.com', Yii::$app->security->generatePasswordHash('user123')],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
