<?php

use yii\db\Migration;

class m170326_131854_migr extends Migration
{
    public function up()
    {
        $this->execute("SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `players`
-- ----------------------------
DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `sname` varchar(150) DEFAULT NULL,
  `birthday` varchar(50) DEFAULT NULL,
  `position` int(5) DEFAULT NULL,
  `team_id` int(7) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `year_create` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
");
    }

    public function down()
    {
        echo "m170326_131854_migr cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction.
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m170326_131854_migr cannot be reverted.\n";

        return false;
    }
    */
}
