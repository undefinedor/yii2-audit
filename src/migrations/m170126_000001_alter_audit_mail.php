<?php

use yii\db\Migration;
use yii\db\Schema;

class m170126_000001_alter_audit_mail extends Migration
{
    const TABLE = '{{%audit_mail}}';

    public function up()
    {
        $this->alterColumn(self::TABLE, 'data', 'LONGBLOB');
    }

}
