<?php

namespace Zendaemon\Services\Tests\Extra;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestModel extends Model
{
    protected $table = 'test_models';

    protected $guarded = [];

    public static function migrate()
    {
        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public static function factory()
    {
        $faker = app(Faker::class);

        return [
            'name' => $faker->name,
        ];
    }
}
