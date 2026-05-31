<?php

namespace App\Console\Commands;

use Database\Seeders\TechStoreSeeder;
use Illuminate\Console\Command;

class SeedTechStoreCommand extends Command
{
    protected $signature = 'store:seed {--fresh : Truncate store tables before seeding}';

    protected $description = 'Seed the tech store with dummy catalog and order data for analytics testing';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            $this->components->warn('Truncating store tables...');
            TechStoreSeeder::truncateStoreData();
        }

        $this->components->info('Seeding tech store data...');
        $this->call('db:seed', ['--class' => TechStoreSeeder::class]);

        $this->components->info('Tech store seeded successfully.');

        return self::SUCCESS;
    }
}
