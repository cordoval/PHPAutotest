#!/bin/bash

delay=1
title="PHPUnit Test Monitor"
OPTIONS=""
notificator=""
soundAvailable=0
sound=0
system=""
file=""
oldMTime=""
newMTime=""

init()
{
  UNAME=$(uname)
  if [[ "$UNAME" = Darwin ]]
  then
    system="osx"
    notificator="growl"
  elif [[ "$UNAME" = *Linux* ]]
  then
    system="linux"
    if [[ `which notify-send` != "" ]]
    then
      notificator="gnome"
    elif [[ `which kdialog` != "" ]]
    then
      #kdialog --passivepopup <text> --title <title> <timeout>
      notificator="kde"
    else
      errorInvalidNotificator
      exit 1
    fi
    if [[ `which espeak` != "" && `which aplay` != "" ]]
    then
      soundAvailable=1
    fi
  else
    errorInvalidSystem
    exit 1
  fi
}

doTheLoop()
{
  while :
  do
    checkFileMTime
    waitOneCicle
  done
}

messageUsage()
{
  echo ""
  echo "Usage: \$ autotest [options] [flags] file"
  echo ""
  echo "Options:"
  echo "  --custom-delay <seconds>  Sets a custom delay of <seconds> seconds. Default: 1"
  echo "  --custom-title \"<title>\"  Sets a custom <title> title for the notifications. Default \"PHPUnit Test Monitor\""
  echo ""
  echo "Flags:"
  echo "  --with-sound        Enables text-to-speech where available (espeak & aplay needed)"
  echo "  --no-notifications  Disables notifications completely"
  echo ""
  echo "Notice: It's recommended to launch this script from where a phpunit.xml configuration file is located in order to benefit of any bootstraping setup that could be made."
  echo ""
  echo "This script has been tested in a OSx system and in a Ubuntu 10.10 system"
  exit 1
}

messageWait()
{
  echo ""
  echo "Waiting for changes in test file"
  echo "(Press ctrl+c to stop this script)"
  echo ""
}

messageExecution()
{
  clear
  echo $(date)
  echo "Executing tests in ${file}"
  echo ""
}

messageDot()
{
  echo -ne "."
}

errorInvalidSystem()
{
  echo ""
  echo "Error: This script can't be executed in your system."
  echo ""
}

errorInvalidNotificator()
{
  echo ""
  echo "Your system is a Linux box but we can't find any valid notification service."
  echo ""
  echo "Please install kdialog or notify-send, or start this script again with --no-notifications flag"
  echo ""
}

errorFileDoesNotExist()
{
  echo ""
  echo "Error: File '${file}' doesn't exist"
  echo ""
}

waitOneCicle()
{
  sleep $delay
  messageDot
}

checkFileMTime() 
{
  case $system in
    "linux") newMTime=`ls -l --full-time ${file} 2> /dev/null | awk '{print $7}'` ;;
    "osx") newMTime=`ls -lT ${file} 2> /dev/null | awk '{print $8}'` ;;
  esac
  if [[ "${newMTime}" == "" ]]
  then
    errorFileDoesNotExist
    exit 1
  fi
  if [[ "${oldMTime}" != "${newMTime}" ]]
  then
    executeTest
  fi
  oldMTime="${newMTime}"
}

executeTest()
{
  messageExecution
  outcome=`phpunit --color "$file" | tail -n2`
  echo "${outcome}"
  notify "${outcome}"
  messageWait
}

notify()
{
  typeset message="$*"
  case $notificator in
    "growl") notifyGrowl "${message}" ;;
    "gnome") notifyGnome "${message}" ;;
    "kde") notifyKDE "${message}" ;;
  esac
}

say()
{
  typeset message="$*"
  espeak -a 200 -p 90 -s 155 -k10 -w /tmp/phpunit_notification.wav "${message}"
  (aplay /tmp/phpunit_notification.wav > /dev/null 2>&1) &
}

notifyGnome()
{
  typeset message="$*"
  notify-send -t 2000 "${title}" "${message}"
  if [[ $sound == 1 ]]
  then
    say "${message}"
  fi
}

notifyKDE()
{
  typeset message="$*"
  kdialog --passivepopup "${message}" --title="${title}" 2
  if [[ $sound == 1 ]]
  then
    say "${message}"
  fi
}

notifyGrowl()
{
  typeset message="$*"
  osascript <<EOD
tell application "GrowlHelperApp"
set the allNotificationsList to {"${title}"}
set the enabledNotificationsList to {"${title}"}
register as application "${title}" all notifications allNotificationsList default notifications enabledNotificationsList icon of application "Terminal.app"
notify with name "${title}" title "${title}" description "${message}" application name "${title}" sticky no priority 0
end tell
EOD
}

debugConfiguration()
{
  echo "OPTIONS: ${OPTIONS}"
  echo ""
  echo "delay: ${delay}"
  echo "title ${title}"
  echo "notificator: ${notificator}"
  echo "soundAvailable: ${soundAvailable}"
  echo "sound: ${sound}"
  echo "system: ${system}"
  echo "file: ${file}"
  echo "oldMTime: ${oldMTime}"
  echo "newMTime: ${newMTime}"
}

# Main thread
#{
  init
  if [[ $# = 0 ]];
  then
    messageUsage
    exit 1
  fi
  while [[ "X$1" = X-* ]]
  do
    if [[ "X$1" = X--no-notifications ]]; then
      notificator="disabled"
      sound=0
    elif [[ "X$1" = X--with-sound ]]; then
      if [[ $soundAvailable == 1 ]]
      then
	sound=1
      fi
    elif [[ "X$1" = X--custom-delay* ]]; then
      delay="$2"
      OPTIONS="$OPTIONS $1"
      shift
    elif [[ "X$1" = X--custom-title* ]]; then
      title="$2"
      OPTIONS="$OPTIONS $1"
      shift
    else
      break;
    fi
    OPTIONS="$OPTIONS $1"
    shift
  done
  file="$1"
  doTheLoop
#}
