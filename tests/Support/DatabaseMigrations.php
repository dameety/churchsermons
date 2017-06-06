<?php

trait DatabaseMigrations

{

    public function runDatabaseMigrations()
    {
        $this->artisan('migrate');
        $this->artisan('db:seed');

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
        });
    }

}
