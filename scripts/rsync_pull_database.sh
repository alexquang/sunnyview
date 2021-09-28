#!/bin/bash
now=`date +"%Y%m%d"`
time rsync ids@10.0.1.116:/home/ids/svdata/ /home/ids/svdata/ \
    --rsh 'ssh -i /home/ids/sunnyview.pem' \
    --rsync-path='sudo rsync' \
    --archive \
    --human-readable \
    --progress \
    --verbose >> /var/log/rsync/rsync_pull_database_${now}.log
docker-compose down && docker-compose up -d