# Autotest

Este script monitoriza ficheros con tests de PHPUnit y los ejecuta cada vez que son modificados.

Además, se comunica con los principales servicios de notificaciones de escritorio:

 - OSx: Mediante Growl (no hace falta instalarse growlnotify)
 - Linux: En Gnome y KDE
 
También puedes activar una función text-to-speech que lee la notificación
 
# Instrucciones
 
 1 Clona el repositorio en algún sitio tranquilo de tu Linux/Mac. Si no te decides, */opt/autotest* puede ser un buen sitio
    git clone https://github.com/Programania/autotest /opt/autotest
 2 Haz el script ejecutable
    chmod +x /opt/autotest/autotest.sh
 3 Enlaza el script en /usr/bin en OSx y en Linux para todos los usuario (o si prefieres, en Linux puedes hacerlo en ~/bin solo para ti)
    ln -s /opt/autotest/autotest.sh /usr/bin

Después de esto ya estás listo para ejecutar unos cuantos tests:

    autotest ~/src/proyecto-de-la-muerte/tests/ChuChuTests.php
    
# Algunas notas

En mi máquina OSx he encontrado que es muy conveniente ejecutar el script desde el directorio donde tengo mi fichero de configuración *phpunit.xml*. De este modo, me aprovecho de cualquier *bootstraping* configurado en el mismo. Sin embargo, este truco no funciona en Ubuntu, aunque aun no he hecho suficientes pruebas.

# ¡Colabora!

No soy experto en *shell-scripting* (evidente si lees el código del script). Si tienes algún tipo de conocimiento o crees que puedes mejorar el rendimiento/eficiencia/corrección del script, hazte un fork y hazme un pull request. Estaré encantado de aplicar cualquier aportación 