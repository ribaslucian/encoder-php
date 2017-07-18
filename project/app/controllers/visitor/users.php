<?php

namespace visitor;

class Users extends \auth\Controller {

    /**
     * Se você usa uma versão inferior ao PHP-5.4 deve remover este recuso.
     * E colocar seus métodos nestas classe para bloquear as ações de um usuário
     * autenticado na área de um usuário não autenticado.
     */
    use \auth\BlockedActionsUnauthenticated;

}
