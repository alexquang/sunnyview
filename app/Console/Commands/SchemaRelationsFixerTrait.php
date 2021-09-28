<?php

namespace App\Console\Commands;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait SchemaRelationsFixerTrait
{
    protected function addRelations()
    {
        $this->dropRelations();

        Schema::table('auth_users', function (Blueprint $table) {
            $this->addCompanyRelation($table);

            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->restrictOnDelete();
        });

        Schema::table('groups', function (Blueprint $table) {
            $this->addCompanyRelation($table);
        });

        Schema::table('projects', function (Blueprint $table) {
            $this->addCompanyRelation($table);

            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->restrictOnDelete();
        });

        Schema::table('auth_assigned_roles', function (Blueprint $table) {
            $table
                ->foreign('auth_role_id')
                ->references('id')
                ->on('auth_roles')
                ->cascadeOnDelete();
        });

        Schema::table('auth_assigned_permissions', function (Blueprint $table) {
            $table
                ->foreign('auth_permission_id')
                ->references('id')
                ->on('auth_permissions')
                ->cascadeOnDelete();
        });

        Schema::table('aws_ami_block_device_mappings', function (Blueprint $table) {
            $table
                ->foreign([
                    'owner_id',
                    'region',
                    'image_id',
                ])
                ->references([
                    'owner_id',
                    'region',
                    'image_id',
                ])
                ->on('aws_amis')
                ->cascadeOnDelete();
        });
    }

    private function dropRelations()
    {
        $tables = \DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();

                $foreignKeys = $sm->listTableForeignKeys($tableName);
                foreach ($foreignKeys as $foreignKey) {
                    $table->dropForeign($foreignKey->getName());
                }
            });
        };

        return $this;
    }

    private function addCompanyRelation(Blueprint $table)
    {
        $table
            ->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->restrictOnDelete();
    }
}
