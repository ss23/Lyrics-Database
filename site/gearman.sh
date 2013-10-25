#!/bin/bash
# Start-stop script for gearman job server and worker process.
# This is needed for album art fetching, and Hot Artist caching.
# Run this as the same user that accesses the website (http, www-data, etc.)

LOCKDIR=/var/tmp/lyricjam_gearman.lock
JOB_LOG=gearmand.log
WORK_LOG=gearmanwork.log

function start {
   if mkdir "$LOCKDIR" 2> /dev/null; then
      echo -n "Starting Gearman.."
      rm $WORK_LOG
      nohup gearmand -d -l $JOB_LOG -P "$LOCKDIR/jobserver.pid" 2>&1 > /dev/null
      nohup Console/cake lastfm worker_start >> $WORK_LOG 2>&1 &
      echo "$!" > "$LOCKDIR/lastfm-worker.pid"
      nohup Console/cake lyricjam start_cache_worker >> $WORK_LOG 2>&1 &
      echo "$!" > "$LOCKDIR/cache-worker.pid"
      echo ".. Done."
   else
      echo "Lock dir exists: $LOCKDIR"
      exit 1
   fi
}

function stop {
   if [ -d "$LOCKDIR" ]; then
      echo -n "Stopping Gearman.."
      cat $LOCKDIR/*.pid | xargs kill
      rm -rf "$LOCKDIR"
      echo ".. Done."
   else
      echo "Gearman is not running." 
      exit 1
   fi
}

function restart {
   if [ -d "$LOCKDIR" ]; then
      stop
      start
   else
      start
   fi
}

case "$1" in
   start)
      start
   ;;
   stop)
      stop
   ;;
   restart)
      restart
   ;;
   *)
      echo "Usage: $0 {start|stop|restart}"
esac
