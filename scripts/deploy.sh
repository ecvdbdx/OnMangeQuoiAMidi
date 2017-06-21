#!/usr/bin/env bash

# Copy built static files to destination
scp -o "StrictHostKeyChecking=no" -r ./src/AppBundle/Resources/public/ $omqam_user@$omqam_host:./src/AppBundle/Resources/;

# Run script there for git fetch, reset, clear cache, install data… etc.
ssh -o "StrictHostKeyChecking=no" $omqam_user@$omqam_host ./scripts/fetchResetAndClearCache.sh
