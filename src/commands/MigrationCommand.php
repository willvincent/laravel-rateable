<?php namespace willvincent\Rateable;

use Illuminate\Console\Command;

class MigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rateable:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Rateable specifications.';

    /**
     * Handle command execution for laravel 5.0
     */
    public function fire()
    {
        $this->handle();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Tables: ratings');
        $this->line('');
        $this->comment('A migration that creates a "ratings" table will be created in the `database/migrations` directory');
        $this->line('');

        if ($this->confirm("Proceed with the migration creation?")) {
            $this->line('');
            $this->info("Creating migration...");
            $this->line('');

            if ($this->createMigration()) {
                $this->info("Migration successfully created!");
            } else {
                $this->error(
                    "Coudn't create migration.\n Check the write permissions".
                    " within the `database/migrations` directory."
                );
            }

            $this->line('');
        }
    }

    /**
     * Create the migration.
     *
     * @return bool
     */
    protected function createMigration()
    {
        $migration_file = database_path('migrations').'/'.date('Y_m_d_His').'_create_ratings_table.php';

        $existing = glob(database_path('migrations').'/*_create_ratings_table.php');

        if (empty($existing) && $fs = fopen($migration_file, 'x')) {
            fwrite($fs, file_get_contents(__DIR__.'/../migrations/create_ratings_table.php'));
            fclose($fs);
            return true;
        }

        return false;
    }
}
