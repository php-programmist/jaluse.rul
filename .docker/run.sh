#!/bin/bash

parent_path=$( cd "$(dirname "${BASH_SOURCE[0]}")" ; pwd -P )
cd "$parent_path"

./stop.sh
docker-compose up -d --remove-orphans --file