<?php

namespace App\Jobs\Aws;

use App\Models\AwsRdsInstance;
use App\Models\AwsRdsInstanceSecurityGroup;
use App\Models\AwsRdsInstanceSubnet;
use App\Models\AwsRdsInstanceVpcSecurityGroup;

class SyncRdsInstanceJob extends SyncJob
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->regions as $region) {
            $client = $this->aws()->createRds(['region' => $region]);

            try {
                \DB::transaction(function () use ($client, $region) {
                    // Delete old data
                    $conditions = [
                        'region' => $region,
                        'owner_id' => $this->account->account_id,
                    ];

                    AwsRdsInstanceSubnet::where($conditions)->delete();

                    AwsRdsInstanceSecurityGroup::where($conditions)->delete();

                    AwsRdsInstanceVpcSecurityGroup::where($conditions)->delete();

                    AwsRdsInstance::where($conditions)->delete();

                    // Get new data from aws
                    $params = [];
                    do {
                        $result = $client->describeDBInstances($params);

                        $dbInstances = $result->get('DBInstances') ?: [];

                        $this->import($region, $dbInstances);
                        // TODO: need to test
                        $params['Marker'] = $result->get('Marker');
                    } while ($params['Marker']);
                });
            } catch (\Throwable $th) {
                echo $th->getMessage() . PHP_EOL;
            }
        }
    }

    private function import($region, array $dbInstances)
    {

        $dbInstanceItems = [];
        $dbSecurityGroupItems = [];
        $subnetItems = [];
        $vpcSecurityGroupItems = [];

        foreach ($dbInstances as $dbInstance) {
            $dbInstanceItem = [
                'owner_id' => $this->account->account_id,
                'region' => $region,

                'activity_stream_engine_native_audit_fields_included' => \Arr::get($dbInstance, 'ActivityStreamEngineNativeAuditFieldsIncluded'),
                'activity_stream_kinesis_stream_name' => \Arr::get($dbInstance, 'ActivityStreamKinesisStreamName'),
                'activity_stream_kms_key_id' => \Arr::get($dbInstance, 'ActivityStreamKmsKeyId'),
                'activity_stream_mode' => \Arr::get($dbInstance, 'ActivityStreamMode'),
                'activity_stream_status' => \Arr::get($dbInstance, 'ActivityStreamStatus'),
                'allocated_storage' => \Arr::get($dbInstance, 'AllocatedStorage'),
                'auto_minor_version_upgrade' => \Arr::get($dbInstance, 'AutoMinorVersionUpgrade'),
                'automatic_restart_time' => \Arr::get($dbInstance, 'AutomaticRestartTime'),
                'availability_zone' => \Arr::get($dbInstance, 'AvailabilityZone'),
                'aws_backup_recovery_point_arn' => \Arr::get($dbInstance, 'AwsBackupRecoveryPointArn'),
                'backup_retention_period' => \Arr::get($dbInstance, 'BackupRetentionPeriod'),
                'ca_certificate_identifier' => \Arr::get($dbInstance, 'CACertificateIdentifier'),
                'character_set_name' => \Arr::get($dbInstance, 'CharacterSetName'),
                'copy_tags_to_snapshot' => \Arr::get($dbInstance, 'CopyTagsToSnapshot'),
                'customer_owned_ip_enabled' => \Arr::get($dbInstance, 'CustomerOwnedIpEnabled'),

                'db_cluster_identifier' => \Arr::get($dbInstance, 'DBClusterIdentifier'),
                'db_instance_arn' => \Arr::get($dbInstance, 'DBInstanceArn'),
                'db_instance_class' => \Arr::get($dbInstance, 'DBInstanceClass'),
                'db_instance_identifier' => \Arr::get($dbInstance, 'DBInstanceIdentifier'),
                'db_instance_status' => \Arr::get($dbInstance, 'DBInstanceStatus'),
                'db_name' => \Arr::get($dbInstance, 'DBName'),

                // DBSubnetGroup
                'db_subnet_group_arn' => \Arr::get($dbInstance, 'DBSubnetGroup.DBSubnetGroupArn'),
                'db_subnet_group_description' => \Arr::get($dbInstance, 'DBSubnetGroup.DBSubnetGroupDescription'),
                'db_subnet_group_name' => \Arr::get($dbInstance, 'DBSubnetGroup.DBSubnetGroupName'),
                'db_subnet_group_status' => \Arr::get($dbInstance, 'DBSubnetGroup.SubnetGroupStatus'),
                'db_subnet_group_vpc_id' => \Arr::get($dbInstance, 'DBSubnetGroup.VpcId'),

                'db_instance_port' => \Arr::get($dbInstance, 'DbInstancePort'),
                'dbi_resource_id' => \Arr::get($dbInstance, 'DbiResourceId'),
                'deletion_protection' => \Arr::get($dbInstance, 'DeletionProtection'),
                'enabled_cloudwatch_logs_exports' => json_encode(\Arr::get($dbInstance, 'EnabledCloudwatchLogsExports')),

                // Endpoint
                'endpoint_address' => \Arr::get($dbInstance, 'Endpoint.Address'),
                'endpoint_hosted_zone_id' => \Arr::get($dbInstance, 'Endpoint.HostedZoneId'),
                'endpoint_port' => \Arr::get($dbInstance, 'Endpoint.Port'),

                'engine' => \Arr::get($dbInstance, 'Engine'),
                'engine_version' => \Arr::get($dbInstance, 'EngineVersion'),
                'enhanced_monitoring_resource_arn' => \Arr::get($dbInstance, 'EnhancedMonitoringResourceArn'),
                'iam_database_authentication_enabled' => \Arr::get($dbInstance, 'IAMDatabaseAuthenticationEnabled'),
                'instance_create_time' => \Arr::get($dbInstance, 'InstanceCreateTime'),
                'iops' => \Arr::get($dbInstance, 'Iops'),
                'kms_key_id' => \Arr::get($dbInstance, 'KmsKeyId'),
                'latest_restorable_time' => \Arr::get($dbInstance, 'LatestRestorableTime'),
                'license_model' => \Arr::get($dbInstance, 'LicenseModel'),

                // ListenerEndpoint
                'listener_endpoint_address' => \Arr::get($dbInstance, 'ListenerEndpoint.Address'),
                'listener_endpoint_hosted_zone_id' => \Arr::get($dbInstance, 'ListenerEndpoint.HostedZoneId'),
                'listener_endpoint_port' => \Arr::get($dbInstance, 'ListenerEndpoint.Port'),

                'master_username' => \Arr::get($dbInstance, 'MasterUsername'),
                'max_allocated_storage' => \Arr::get($dbInstance, 'MaxAllocatedStorage'),
                'monitoring_interval' => \Arr::get($dbInstance, 'MonitoringInterval'),
                'monitoring_role_arn' => \Arr::get($dbInstance, 'MonitoringRoleArn'),
                'multi_az' => \Arr::get($dbInstance, 'MultiAZ'),
                'nchar_character_set_name' => \Arr::get($dbInstance, 'NcharCharacterSetName'),

                'performance_insights_enabled' => \Arr::get($dbInstance, 'PerformanceInsightsEnabled'),
                'performance_insights_kms_key_id' => \Arr::get($dbInstance, 'PerformanceInsightsKMSKeyId'),
                'performance_insights_retention_period' => \Arr::get($dbInstance, 'PerformanceInsightsRetentionPeriod'),
                'preferred_backup_window' => \Arr::get($dbInstance, 'PreferredBackupWindow'),
                'preferred_maintenance_window' => \Arr::get($dbInstance, 'PreferredMaintenanceWindow'),

                'promotion_tier' => \Arr::get($dbInstance, 'PromotionTier'),
                'publicly_accessible' => \Arr::get($dbInstance, 'PubliclyAccessible'),
                'read_replica_db_cluster_identifiers' => json_encode(\Arr::get($dbInstance, 'ReadReplicaDBClusterIdentifiers')),
                'read_replica_db_instance_identifiers' => json_encode(\Arr::get($dbInstance, 'ReadReplicaDBInstanceIdentifiers')),
                'read_replica_source_db_instance_identifier' => \Arr::get($dbInstance, 'ReadReplicaSourceDBInstanceIdentifier'),
                'replica_mode' => \Arr::get($dbInstance, 'ReplicaMode'),
                'secondary_availability_zone' => \Arr::get($dbInstance, 'SecondaryAvailabilityZone'),
                'storage_encrypted' => \Arr::get($dbInstance, 'StorageEncrypted'),
                'storage_type' => \Arr::get($dbInstance, 'StorageType'),
                'tde_credential_arn' => \Arr::get($dbInstance, 'TdeCredentialArn'),
                'timezone' => \Arr::get($dbInstance, 'Timezone'),
            ];
            // aws_rds_instances
            $dbInstanceItems[] = $dbInstanceItem;

            // aws_rds_instance_security_groups
            $dbSecurityGroups = \Arr::get($dbInstance, 'DBSecurityGroups') ?: [];
            foreach ($dbSecurityGroups as $dbSecurityGroup) {
                $dbSecurityGroupItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,
                    'db_instance_identifier' => $dbInstanceItem['db_instance_identifier'],
                    'db_security_group_name' => \Arr::get($dbSecurityGroup, 'DBSecurityGroupName'),
                    'status' => \Arr::get($dbSecurityGroup, 'Status'),
                ];
                $dbSecurityGroupItems[] = $dbSecurityGroupItem;
            }

            // aws_rds_instance_subnets
            $subnets = \Arr::get($dbInstance, 'DBSubnetGroup.Subnets') ?: [];
            foreach ($subnets as $subnet) {
                $subnetItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,
                    'db_instance_identifier' => $dbInstanceItem['db_instance_identifier'],
                    'subnet_availability_zone' => \Arr::get($subnet, 'SubnetAvailabilityZone.Name'),
                    'subnet_identifier' => \Arr::get($subnet, 'SubnetIdentifier'),
                    'subnet_outpost_arn' => \Arr::get($subnet, 'SubnetOutpost.Arn'),
                    'subnet_status' => \Arr::get($subnet, 'SubnetStatus'),
                ];
                $subnetItems[] = $subnetItem;
            }

            // vpc VpcSecurityGroups
            $vpcSecurityGroups = \Arr::get($dbInstance, 'VpcSecurityGroups') ?: [];
            foreach ($vpcSecurityGroups as $vpcSecurityGroup) {
                $vpcSecurityGroupItem = [
                    'owner_id' => $this->account->account_id,
                    'region' => $region,
                    'db_instance_identifier' => $dbInstanceItem['db_instance_identifier'],
                    'vpc_security_group_id' => \Arr::get($vpcSecurityGroup, 'VpcSecurityGroupId'),
                    'status' => \Arr::get($vpcSecurityGroup, 'Status'),
                ];
                $vpcSecurityGroupItems[] = $vpcSecurityGroupItem;
            }
        }

        \DB::table('aws_rds_instances')->insert($dbInstanceItems);
        \DB::table('aws_rds_instance_security_groups')->insert($dbSecurityGroupItems);
        \DB::table('aws_rds_instance_subnets')->insert($subnetItems);
        \DB::table('aws_rds_instance_vpc_security_groups')->insert($vpcSecurityGroupItems);
    }
}
