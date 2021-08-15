<?php


    namespace App\Actions\Tenant;


    use Illuminate\Support\Facades\DB;

    class CreateTenantDatabaseAction
    {

        public function execute(string $tenant) : string
        {
            $dbName = random_string(7) . "_{$tenant}";
            DB::connection(config('env.tenant.tenantConnection'))->select("CREATE DATABASE $dbName");

            //@todo grant full permissions on database to user
//            DB::connection(config('env.tenant.tenantConnection'))->statement("GRANT ALL PRIVILEGES ON :schema.* TO ':user'@':host'", [
//                'schema' => $dbName,
//                'user' => config('database.connections.username'),
//                'host' => config('database.connections.host'),
//            ]);
            return $dbName;
        }
    }
