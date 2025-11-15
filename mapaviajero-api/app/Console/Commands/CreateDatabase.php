<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la base de datos si no existe.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $port = env('DB_PORT', 3306);
        $connection = env('DB_CONNECTION', 'mysql');

        try {
            if ($connection === 'mysql') {
                $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
                $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            } elseif ($connection === 'pgsql') {
                $pdo = new PDO("pgsql:host=$host;port=$port", $username, $password);
                $pdo->exec("CREATE DATABASE \"$database\";");
            } else {
                $this->error("Conexión $connection no soportada para crear la BBDD automáticamente.");
                return;
            }

            $this->info("Base de datos '$database' creada o ya existente.");
        } catch (\Exception $e) {
            $this->error("Error creando la base de datos: " . $e->getMessage());
        }
    }
}
