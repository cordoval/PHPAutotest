# Autotest PHPUnit/PHPSpec

Monitors files with PHPUnit/PHPSpec tests and executes them each time they are modified.

##Instructions:

```php
sudo apt-get install libnotify-bin
sudo apt-get install inotify-tools
git clone git://github.com/cordoval/autotest-phpunit.git /opt/autotest-phpunit
chmod +x /opt/autotest-phpunit/autotest.sh
chmod +x /opt/autotest-phpunit/autotest.php
ln -s /opt/autotest-phpunit/autotest.sh /usr/bin/autotest
ln -s /opt/autotest-phpunit/autotest.php /usr/bin/autotest2
autotest ~/src/proyecto-de-la-muerte/tests/ChuChuTests.php
autotest2 NewBowlingGameSpec.php
```