#!/bin/bash
current_dir=$(dirname "$(realpath $0)")
/opt/php/8.0/bin/php $current_dir/bin/console cache:clear
rm $current_dir/var/cache/prod/* -rf
rm $current_dir/var/cache/dev/* -rf
