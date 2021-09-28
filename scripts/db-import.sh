#!/bin/bash
currentDir="$(dirname $(readlink -f "$0"))"
docker cp "$currentDir"/svdb_default.pgsql.gz sunnyview-postgres:"/var/tmp/svdb_default.pgsql.gz"
docker cp "$currentDir"/svdb_billing.pgsql.gz sunnyview-postgres:"/var/tmp/svdb_billing.pgsql.gz"
docker exec sunnyview-postgres bash \
    -c 'gunzip -f /var/tmp/svdb_default.pgsql.gz && psql -U root -d svdb_default < /var/tmp/svdb_default.pgsql'
docker exec sunnyview-postgres bash \
    -c 'gunzip -f /var/tmp/svdb_billing.pgsql.gz && psql -U root -d svdb_billing < /var/tmp/svdb_billing.pgsql && rm -f /var/tmp/svdb_.*'
