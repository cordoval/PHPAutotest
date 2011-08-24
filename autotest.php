#!/bin/php
<?php
/*
 * This version of autotest.php is geared towards the usage
 * with phpspec (see phpspec.net)
 *
 *
 */

do {
    checkFileMTime();
    waitOneCicle();

    // check for exit command or something @TODO add

} while ();

public function messageUsage()
{
  echo "\n";
  echo "Usage: \$ autotest [options] [flags] file";
  echo "\n";
  echo "Options:";
  echo "  --custom-delay <seconds>  Sets a custom delay of <seconds> seconds. Default: 1";
  echo "  --custom-title \"<title>\"  Sets a custom <title> title for the notifications. Default \"PHPUnit Test Monitor\"";
  echo "\n";
  echo "Flags:";
  echo "  --with-sound        Enables text-to-speech where available (espeak & aplay needed)";
  echo "  --no-notifications  Disables notifications completely";
  echo "\n";
  echo "Notice: It's recommended to launch this script from where a phpunit.xml configuration file is located in order to benefit of any bootstraping setup that could be made.";
  echo "\n"
  echo "This script has been tested in a OSx system and in a Ubuntu 10.10 system";
  return 1;
}

public function messageWait()
{
  echo "\n";
  echo "Waiting for changes in test file. Press 'r' key to force test execution";
  echo "(Press ctrl+c to stop this script)";
  echo "\n";
}

public function messageExecution()
{
  // @TODO here issue a "clear"
  echo $(date);
  echo "Executing tests in ${file}";
  echo "\n";
  return 1;
}

public function messageDot()
{
  // @TODO what is -ne? o repeating the ........ of phpspec :D ?
  echo -ne ".";
}

public function errorInvalidSystem()
{
  echo "\n";
  echo "Error: This script can't be executed in your system.";
  echo "\n";
}

public function errorInvalidNotificator()
{
  echo "\n";
  echo "Your system is a Linux box but we can't find any valid notification service.";
  echo "\n";
  echo "Please install kdialog or notify-send, or start this script again with --no-notifications flag";
  echo "\n";
}

public function errorFileDoesNotExist()
{
  echo "\n";
  echo "Error: File '${file}' doesn't exist";
  echo "\n";
}

public function waitOneCicle()
{
  // @TODO: copy here the key stroke from keyboard (I have this ready)
  read -p"." -t1 -n1 keystroke
  if ( "$?" -eq 0  &&  "$keystroke" == "r") {
    executeTest();
  }
}

public function checkFileMTime()
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

public function executeTest()
{
  messageExecution();
  $outcome = 'phpspec "$file" -c'
  echo "${outcome}";
  exec('notify "echo \"${outcome}\" | tail -n2');
  messageWait();
}

public function notify()
{
  // @TODO:
  typeset message="$*"
  message=$(printf %q $message | sed 's/\\//g' | sed 's/\$//g' | sed 's/E\[0mE\[37;41mE\[2K//g' | sed 's/E\[30;42mE\[2K//g' | sed 's/E\[0mE\[2K//g' | sed "s/'//g" | sed 's/,A/ \(A/g' | sed 's/\./)/g' | sed 's/,/, /g' | sed 's/tests/ tests/g' | sed 's/assertions/ assertions/g' | sed 's/OK/OK /g')
  case $notificator in
    "gnome") notifyGnome "${message}" ;;
  esac
  notify-send -t 2000 "${title}" "${message}"
  //espeak -a 200 -p 90 -s 155 -k10 -w /tmp/phpunit_notification.wav "${message}"
  //(aplay /tmp/phpunit_notification.wav > /dev/null 2>&1) &
}
?>