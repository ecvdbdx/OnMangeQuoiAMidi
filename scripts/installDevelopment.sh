#!/usr/bin/env bash

# Set current directory
BASEDIR=$(dirname "$0")

# Setup the database
./$BASEDIR/resetDb.sh

# Populate the database
./$BASEDIR/populateDb.sh
