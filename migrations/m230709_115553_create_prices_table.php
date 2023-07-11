<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%prices}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tonnages}}`
 * - `{{%months}}`
 * - `{{%raw_types}}`
 */
class m230709_115553_create_prices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%prices}}', [
            'id' => $this->primaryKey(),
            'tonnage_id' => $this->integer(11)->notNull()->unsigned(),
            'month_id' => $this->integer(11)->notNull()->unsigned(),
            'raw_type_id' => $this->integer(11)->notNull()->unsigned(),
            'price' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `tonnage_id`
        $this->createIndex(
            '{{%idx-prices-tonnage_id}}',
            '{{%prices}}',
            'tonnage_id'
        );

        // add foreign key for table `{{%tonnages}}`
        $this->addForeignKey(
            '{{%fk-prices-tonnage_id}}',
            '{{%prices}}',
            'tonnage_id',
            '{{%tonnages}}',
            'id',
            'CASCADE',
            'NO ACTION',
        );

        // creates index for column `month_id`
        $this->createIndex(
            '{{%idx-prices-month_id}}',
            '{{%prices}}',
            'month_id'
        );

        // add foreign key for table `{{%months}}`
        $this->addForeignKey(
            '{{%fk-prices-month_id}}',
            '{{%prices}}',
            'month_id',
            '{{%months}}',
            'id',
            'CASCADE',
            'NO ACTION',
        );

        // creates index for column `raw_type_id`
        $this->createIndex(
            '{{%idx-prices-raw_type_id}}',
            '{{%prices}}',
            'raw_type_id'
        );

        // add foreign key for table `{{%raw_types}}`
        $this->addForeignKey(
            '{{%fk-prices-raw_type_id}}',
            '{{%prices}}',
            'raw_type_id',
            '{{%raw_types}}',
            'id',
            'CASCADE',
            'NO ACTION',
        );

        $this->createIndex(
            'idx-prices-tonnage-month-raw',
            'prices',
            ['tonnage_id', 'month_id', 'raw_type_id'],
            true,
        );

        //Заполнение таблицы прайсов
        $this->batchInsert('prices', ['tonnage_id', 'month_id', 'raw_type_id', 'price'], [
            //Шрот
            //25 тонн
            [1, 1, 1, 125],
            [1, 2, 1, 121],
            [1, 3, 1, 137],
            [1, 4, 1, 126],
            [1, 5, 1, 124],
            [1, 6, 1, 128],
            //50 тонн
            [2, 1, 1, 145],
            [2, 2, 1, 118],
            [2, 3, 1, 119],
            [2, 4, 1, 121],
            [2, 5, 1, 122],
            [2, 6, 1, 147],
            //75 тонн
            [3, 1, 1, 136],
            [3, 2, 1, 137],
            [3, 3, 1, 141],
            [3, 4, 1, 137],
            [3, 5, 1, 131],
            [3, 6, 1, 143],
            //100 тонн
            [4, 1, 1, 138],
            [4, 2, 1, 142],
            [4, 3, 1, 117],
            [4, 4, 1, 124],
            [4, 5, 1, 147],
            [4, 6, 1, 112],

            //Жмых
            //25 тонн
            [1, 1, 2, 121],
            [1, 2, 2, 137],
            [1, 3, 2, 124],
            [1, 4, 2, 137],
            [1, 5, 2, 122],
            [1, 6, 2, 125],
            //50 тонн
            [2, 1, 2, 118],
            [2, 2, 2, 121],
            [2, 3, 2, 145],
            [2, 4, 2, 147],
            [2, 5, 2, 143],
            [2, 6, 2, 145],
            //75 тонн
            [3, 1, 2, 137],
            [3, 2, 2, 124],
            [3, 3, 2, 136],
            [3, 4, 2, 143],
            [3, 5, 2, 112],
            [3, 6, 2, 136],
            //100 тонн
            [4, 1, 2, 142],
            [4, 2, 2, 131],
            [4, 3, 2, 138],
            [4, 4, 2, 112],
            [4, 5, 2, 117],
            [4, 6, 2, 138],

            //Соя
            //25 тонн
            [1, 1, 3, 137],
            [1, 2, 3, 125],
            [1, 3, 3, 124],
            [1, 4, 3, 122],
            [1, 5, 3, 137],
            [1, 6, 3, 121],
            //50 тонн
            [2, 1, 3, 147],
            [2, 2, 3, 145],
            [2, 3, 3, 145],
            [2, 4, 3, 143],
            [2, 5, 3, 119],
            [2, 6, 3, 118],
            //75 тонн
            [3, 1, 3, 112],
            [3, 2, 3, 136],
            [3, 3, 3, 136],
            [3, 4, 3, 112],
            [3, 5, 3, 141],
            [3, 6, 3, 137],
            //100 тонн
            [4, 1, 3, 122],
            [4, 2, 3, 138],
            [4, 3, 3, 138],
            [4, 4, 3, 117],
            [4, 5, 3, 117],
            [4, 6, 3, 142],
        ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tonnages}}`
        $this->dropForeignKey(
            '{{%fk-prices-tonnage_id}}',
            '{{%prices}}'
        );

        // drops index for column `tonnage_id`
        $this->dropIndex(
            '{{%idx-prices-tonnage_id}}',
            '{{%prices}}'
        );

        // drops foreign key for table `{{%months}}`
        $this->dropForeignKey(
            '{{%fk-prices-month_id}}',
            '{{%prices}}'
        );

        // drops index for column `month_id`
        $this->dropIndex(
            '{{%idx-prices-month_id}}',
            '{{%prices}}'
        );

        // drops foreign key for table `{{%raw_types}}`
        $this->dropForeignKey(
            '{{%fk-prices-raw_type_id}}',
            '{{%prices}}'
        );

        // drops index for column `raw_type_id`
        $this->dropIndex(
            '{{%idx-prices-raw_type_id}}',
            '{{%prices}}'
        );

        $this->dropTable('{{%prices}}');
    }
}
