#!/bin/bash
time rsync /usr/local/apache2/akatsuki/ ids@10.0.3.96:/usr/local/apache2/akatsuki/ \
    --rsh 'ssh -i /home/ids/sunnyview.pem' \
    --exclude '.env' \
    --exclude 'setup/cronlogs' \
    --exclude '.env' \
    --exclude 'storage/app/temp' \
    --exclude 'storage/logs' \
    --archive \
    --verbose \
    --progress \
    --human-readable \
    --delete-after