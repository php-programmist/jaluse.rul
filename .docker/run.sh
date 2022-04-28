#!/bin/bash

log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')][rebuild]"
    MESSAGE=$1
    echo "$LOGPREFIX $MESSAGE"
}

./stop.sh

log_message "Starting containers..."
docker-compose up -d --remove-orphans --build