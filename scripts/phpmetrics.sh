#!/usr/bin/env bash

rm -Rf web/phpmetrics;
./vendor/phpmetrics/phpmetrics/bin/phpmetrics --report-html=web/phpmetrics src;