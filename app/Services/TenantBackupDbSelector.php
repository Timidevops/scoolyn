<?php

    namespace App\Services;

    use App\Models\Tenant\ScoolynTenant;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Collection;
    use Spatie\Backup\Tasks\Backup\DbDumperFactory;
    use Spatie\DbDumper\Databases\MySql;
    use Spatie\DbDumper\DbDumper;

    class TenantBackupDbSelector extends DbDumperFactory
    {
        public static function getTenantDatabaseConnections(): Collection
        {
            $schools = ScoolynTenant::all();

            return $schools->map(function ($tenant) {
                return self::createConnection($tenant->database);
            });
        }

        public static function createConnection(string $tenantDbName): DbDumper
        {
            $dbConfig = config('database.connections.tenant', 'system');

            $dbDumper = static::forDriver($dbConfig['driver'])
                ->setHost(Arr::first(Arr::wrap($dbConfig['host'] ?? '')))
                ->setDbName($tenantDbName)
                ->setUserName($dbConfig['username'] ?? '')
                ->setPassword($dbConfig['password'] ?? '');
            if ($dbDumper instanceof MySql) {
                $dbDumper->setDefaultCharacterSet($dbConfig['charset'] ?? '');
            }
            if (isset($dbConfig['port'])) {
                $dbDumper = $dbDumper->setPort($dbConfig['port']);
            }
            if (isset($dbConfig['dump'])) {
                $dbDumper = static::processExtraDumpParameters($dbConfig['dump'], $dbDumper);
            }

            return $dbDumper;
        }
    }
