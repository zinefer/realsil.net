#!/bin/bash

function deploy {
    STORAGE_ACCOUNT=${1?}
    DEST="https://$STORAGE_ACCOUNT.blob.core.windows.net/\$web"
    azcopy_v10 sync --delete-destination=true --recursive public $DEST
}

function help {
    echo "$0 <task> <args>"
    echo "Tasks:"
    compgen -A function | cat -n
}

TIMEFORMAT="Task completed in %3lR"
time ${@:-help}