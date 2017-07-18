<?php

namespace admin;

class Users extends \auth\Controller {

    /**
     * Se você usa uma versão inferior ao PHP-5.4 deve remover este recuso.
     * E colocar seus métodos nestas classe caso bloquear as ações de um usuário
     * não autenticado na área de um usuário autenticado.
     */
    use \auth\BlockedActionsAuthenticated;

}
