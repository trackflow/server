#!/usr/bin/env sh
set -e

pid=0

# SIGUSR1-handler
my_handler() {
  echo "trackflow"
}

# SIGTERM-handler
term_handler() {
  if [ $pid -ne 0 ]; then
    kill -SIGTERM "$pid"
    wait "$pid"
  fi
  exit 143; # 128 + 15 -- SIGTERM
}

# setup handlers
# on callback, kill the last background process, which is `tail -f /dev/null` and execute the specified handler
# shellcheck disable=SC2039
trap 'kill ${!}; my_handler' SIGUSR1
# shellcheck disable=SC2039
trap 'kill ${!}; term_handler' SIGTERM

# run application
php server.php &
pid="$!"

# wait forever
while true
do
  tail -f /dev/null & wait ${!}
done