<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Diariamente -> Daily
        // Dias laborales -> business days
        // Semanalmente -> Weekly
        // Mensualmente -> Monthly
        // Anualmente -> Annually
        // Personalizado -> Personalized
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title', 70);
            $table->text('content')->nullable();
            $table->char('background_color', 7)->default('#FFFFFF');
            $table->char('text_color', 7)->default('#6b7280');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('users');
            $table->dateTime('date_expiration')->nullable();
            $table->dateTime('date_remind_me')->nullable();
            $table->dateTime('date_my_day')->nullable();
            $table->enum('repeat_task', ['Diariamente', 'Dias laborales', 'Semanalmente', 'Mensualmente', 'Anualmente', 'Personalizado'])->nullable();
            $table->char('customize_repeat')->nullable();
            // $table->boolean('store_tank')->default(false);
            $table->boolean('priority')->default(false);
            $table->enum('status', ['Pendiente', 'Trabajando', 'Completado', 'Retrasado'])->default('Pendiente');
            $table->unsignedBigInteger('board_id');
            $table->foreign('board_id')->references('id')->on('boards');
            $table->unsignedBigInteger('taskable_id')->nullable();
            $table->string('taskable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
