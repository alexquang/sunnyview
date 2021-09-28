array=(
    admin_configs
    admins
    aws_accounts
    aws_cw_rules
    aws_load_balancers
    aws_vpcs
    billing_download_histories
    cache
    ccard
    chart_cost_by_services
    chart_daily_cost_by_services
    chart_ec2_usage
    chart_ec2_usage_details
    chart_storage_usage
    command_schedule
    configs
    contracts
    customers_ri_usage
    customers_ris
    cw_logs
    cw_logs_events
    cw_rules
    dept
    ebs_change_req
    ebs_log
    ebs_req
    ebs_req_detail
    ec2_addresses
    ec2_ami_block_devices
    ec2_amis
    ec2_block_devices
    ec2_enabled_amis
    ec2_enabled_instance_types
    ec2_enabled_regions
    ec2_instance_lifecycle_policies
    ec2_instance_registration_block_devices
    ec2_instance_registration_security_group_permissions
    ec2_instance_registration_security_groups
    ec2_instance_registration_specs
    ec2_instance_security_groups
    ec2_instance_types
    ec2_instances
    ec2_regions
    ec2_security_group_permissions
    ec2_security_groups
    ec2_snapshots
    ec2_temp_instance_types
    ec2_zones
    emp
    emp_settings
    event_logs
    failed_jobs
    faq
    history_admin_operation
    info
    info_read
    instances_auto_run_settings
    invoice2
    invoice_download_notification_settings
    invoice_fees
    invoice_notes
    invoice_override
    invoice_settings
    invoice_visibility_settings
    jcode
    jobs
    lifecycle_policies
    migrations
    model_has_permissions
    model_has_roles
    ms_action_logs
    ms_rds_cost
    ms_rds_info
    mst_tag_values
    mst_tags
    navigations
    oauth_access_tokens
    oauth_auth_codes
    oauth_clients
    oauth_personal_access_clients
    oauth_refresh_tokens
    obj
    password_resets
    permissions
    proj
    proj_assigns
    rate
    rds_instance
    rds_instance_requests
    rds_instance_types
    ri_notifications
    role_has_permissions
    roles
    route_permissions
    setting_auto_start_stop
    trusttree
    user_notification_email
    user_settings
    users
)
for i in "${array[@]}"
do
    PGPASSWORD=Ogura100 psql \
        --host=svdb-staging.clfnmu8brkcn.ap-northeast-1.rds.amazonaws.com \
        --username=sunnyview \
        --dbname=svdb \
        --command="DROP TABLE IF EXISTS $i";
done

for i in "${array[@]}"
do
    PGPASSWORD=Ogura100 pg_dump \
        --host=sunnyview-ids-db.clfnmu8brkcn.ap-northeast-1.rds.amazonaws.com \
        --username=sunnyview \
        --dbname=awsfw_latest \
        --table=$i | \
    PGPASSWORD=Ogura100 psql \
        --host=svdb-staging.clfnmu8brkcn.ap-northeast-1.rds.amazonaws.com \
        --username=sunnyview \
        --dbname=svdb
done