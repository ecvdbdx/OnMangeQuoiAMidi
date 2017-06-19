#!/usr/bin/env bash

rm -Rf web/phpmetrics;
phpmetrics --report-html=web/phpmetrics src;