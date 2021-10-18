<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderDefaultBroadlistTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_default_broadlist';
    public $table_comment = 'default broadcast list for a reminder (directly attached)';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('broadlist_id')->nullable()
                ->comment('reminder broadcast list reference')
                ->constrained('reminder_broadlists')->onDelete('set null');

            $table->foreignId('reminder_id')->nullable()
                ->comment('reminder reference')
                ->constrained('reminders')->onDelete('set null');

            $table->string('description')->nullable()->comment('relation description');

            $table->timestamps();
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropForeign(['broadlist_id']);
            $table->dropForeign(['reminder_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
