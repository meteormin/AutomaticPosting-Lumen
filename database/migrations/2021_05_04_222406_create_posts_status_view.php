<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsStatusView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->dropView());
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW `posts_status` AS
                SELECT
                    `type`,
                    COUNT(`type`) AS `type_count`,
                    `code`,
                    COUNT(`code`) AS `code_count`
                FROM `posts`
                WHERE
                    `posts`.`deleted_at` IS NULL
                GROUP BY `type`,`code`
        SQL;
    }

    private function dropView(): string
    {
        return <<<SQL
            DROP VIEW IF EXISTS `posts_status`
        SQL;
    }
}
