#!/usr/bin/env bash
# run chrome driver
# if you want auto start, copy to /etc/profile.d/
# shellcheck disable=SC2091
# shellcheck disable=SC2164
cd /home/minyuz/lumen;php artisan chromedriver:start

echo 'start chromedriver'

screen -list

