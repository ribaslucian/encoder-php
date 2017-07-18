<?php

# constantes de diretorios no {Servidor}
define('INIT_FILE', 'config/init.php');
define('I', DIRECTORY_SEPARATOR);
define('SERVER', str_replace(array('\\', '/'), I, $_SERVER['DOCUMENT_ROOT']));
define('URI', str_replace(array(INIT_FILE, '\\', '/'), array('', I, I), $_SERVER['SCRIPT_NAME'])); # verificar se em servidor Win a barra deve ser invertida.
define('ROOT', SERVER . URI);
define('SHARED', ROOT . '..' . I . '$shared' . I);

require SHARED . 'config' . I . 'init.php';
