<?php

/**
 * @config Encoder
 */
# escondendo errors do tipo STRIC
error_reporting(E_ALL ^ E_STRICT);
set_time_limit(60 * 3);

# constantes basicas de diretorios
define('PROJECT_FOLDER', basename(ROOT));

# definindo zona e localizacao
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');

# constantes de diretorios no {Projeto}
define('APP', ROOT . 'app' . I);
define('ASSETS', ROOT . 'assets' . I);
define('DATA', ROOT . 'data' . I);
define('ENCODER', SHARED . '$encoder' . I);
define('CONFIG', ROOT . 'config' . I);

# constantes dos diretorios do {Encoder}
define('LIB', ENCODER . 'lib' . I);
define('ENCODER_LAYOUTS', ENCODER . 'view' . I . 'layouts' . I);

# constantes dos diretorios da {Aplicacao}
define('VIEWS', APP . 'views' . I);
define('TEMPLATES', SHARED . 'views' . I . 'templates' . I);

# constantes dos diretorios das {Assets}
define('JAVASCRIPTS', ASSETS . 'javascripts' . I);
define('STYLESHEETS', ASSETS . 'stylesheets' . I);

# constantes dos diretorios de {Data}
define('CACHE', DATA . 'cache' . I);
define('DATABASE', DATA . 'database' . I);
define('LOG', DATA . 'log' . I);
define('SQL', DATABASE . 'scripts' . I);

# funcoes basicas
include LIB . 'functions.php';

# informando ao PHP a existência de funcoes basicas personalidas
spl_autoload_register('encoder_autoload');
set_exception_handler('encoder_exception');

# incluindo as classes basicas {Object, Encoder, Cache, Dir}
include LIB . 'object.php';
include CONFIG . 'object.php';
include LIB . 'encoder.php';

# iniciando contagem do tempo de execucao da aplicacao
encoder_timer();

# definindo o nome do {Controller} base do frameowork. Necessario para que as
# classes possam idenficar quando utilizam de um {Controller} valido
encoder_controller('encoder\Controller');

# definindo o nome do {Model} base do frameowork. Necessario para que as
# classes possam idenficar quando utilizam de um {Model} valido
encoder_model('encoder\Model');

include LIB . 'dir.php';
include ENCODER . 'authoritarian' . I . 'cache.php';
include CONFIG . 'cache.php';

# lendo as classes da aplicacao (Area comunente cacheada)
dir_classes_application();

#
# A PARTIR DAQUI EH APLICACAO
#

include CONFIG . 'seeds.php';
include CONFIG . '@debug.php';
include SHARED . 'lib' . I . 'liv_functions.php';

# Verificando se a rota atual eh valida, caso nao seja mandamos para um valida.
if (!route_is())
    go();

# efetuando a chamada da rota.
route_call();
