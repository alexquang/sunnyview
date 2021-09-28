#!/bin/bash
LOGDIRECTORY="/home/ids/rsync/log/"
SUCCESSLOGFILE="success-`date +"%Y-%m-%d"`.log"
ERRORLOGFILE="error-`date +"%Y-%m-%d"`.log"
MAILFROM="SunnyView Center [NO-REPLY] <sunnyview-center@ids.co.jp>"
MAILTO="sunnyview-sys@vn.ids.jp"

if [ ! -e $LOGDIRECTORY ]
then
    mkdir -p $LOGDIRECTORY
fi

sendSuccessMail=0
if [ ! -e $LOGDIRECTORY$SUCCESSLOGFILE ]
then
    sendSuccessMail=1
fi
find "$LOGDIRECTORY"success-*.log -not -name "$SUCCESSLOGFILE" -type f -delete

sendErrorMail=0
if [ ! -e $LOGDIRECTORY$ERRORLOGFILE ]
then
    sendErrorMail=1
else
    line=$(head -n 1 $LOGDIRECTORY$ERRORLOGFILE)
fi
find "$LOGDIRECTORY"error-*.log -not -name "$ERRORLOGFILE" -type f -delete

commandStartedAt=`date +"%Y-%m-%d %T"`
commandOutput=`(time rsync ids@10.0.1.116:/usr/local/apache2/akatsuki/ /usr/local/apache2/akatsuki/ \
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
) 2>&1`
commandExitCode=$?
commandStoppedAt=`date +"%Y-%m-%d %T"`

subject=""
logFile=""
if [ $commandExitCode -eq 0 ]
then
    echo "$commandOutput" > $LOGDIRECTORY$SUCCESSLOGFILE

    # Do not send success mail in case already sent
    if [ $sendSuccessMail -eq 1 ]
    then
        subject="【正常終了】【本番】 Synchronize Source Notification"
        logFile=$LOGDIRECTORY$SUCCESSLOGFILE
    fi
else
    echo "ErrorCode=$commandExitCode" > $LOGDIRECTORY$ERRORLOGFILE
    echo "$commandOutput" >> $LOGDIRECTORY$ERRORLOGFILE

    # Do not send error mail consecutively
    if [ $sendErrorMail -eq 1 -o "$line" != "ErrorCode=$commandExitCode" ]
    then
        subject="【異常終了】【本番】 Synchronize Source Notification"
        logFile=$LOGDIRECTORY$ERRORLOGFILE
    fi
fi

if [ -n "$subject" ]
then
    bodyHtml="
        <b>Server:</b> production<br/>
        <b>Command:</b> bash scripts/rsync_pull_source.sh<br/>
        <b>Started At:</b> $commandStartedAt<br/>
        <b>Stopped At:</b> $commandStoppedAt<br/>
        <b>Log file:</b> $logFile<br/>
    "
    bodyText="
        Server: production\r\n
        Command: bash scripts/rsync_pull_source.sh\r\n
        Started At: $commandStartedAt\r\n
        Stopped At: $commandStoppedAt\r\n
        Log file: $logFile\r\n
    "
    message="Subject={Data='$subject',Charset=UTF-8},Body={Text={Data='$bodyText',Charset=UTF-8},Html={Data='$bodyHtml',Charset=UTF-8}}"

    # Send mail
    aws configure set default.region us-east-1
    aws ses send-email --from "$MAILFROM" --to "$MAILTO" --message "$message"
    aws configure set default.region ap-northeast-1
fi