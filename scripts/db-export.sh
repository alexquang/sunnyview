#!/bin/bash
currentDir="$(dirname $(readlink -f "$0"))"
docker exec sunnyview-postgres pg_dump \
    -U root -d svdb_default -Z 9 \
    --oids \
    --no-owner \
    --no-acl \
    --clean \
    --if-exists \
    --exclude-table-data 'public.cost*' \
    --exclude-table-data 'public.insttype_temp' \
    --exclude-table-data 'public.stat_*' \
    --exclude-table-data 'public.stats6m' \
    --exclude-table-data 'public.user_tags' \
    --exclude-table-data 'public.billing' \
    --exclude-table-data 'public.dbrrt_val' \
    --exclude-table-data 'public.inst_*' \
    --exclude-table-data 'public.cw_logs*' \
    > "$currentDir"/svdb_default.pgsql.gz
docker exec sunnyview-postgres pg_dump \
    -U root -d svdb_billing -Z 9 \
    --oids \
    --no-owner \
    --no-acl \
    --clean \
    --if-exists \
    --exclude-table 'rpt_cur_*' \
    --exclude-table 'rpt_dbrrt_*' \
    --exclude-table-data 'tmp_*' \
    > "$currentDir"/svdb_billing.pgsql.gz
