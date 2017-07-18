<?php

class Controller extends encoder\Controller {
    /**
     * Se você usa uma versão inferior ao PHP-5.4 deve remover este recuso.
     * E colocar seus métodos nestas classe caso deseje o controle de acesso dos
     * usuários.
     *
     * Incluímos as validações de usuários e pré definições de um chamada.
     */
    # use \middleware\RequestValidations;

    /**
     * Se você usa uma versão inferior ao PHP-5.4 deve remover este recuso.
     * E colocar seus métodos nestas classe caso deseje as ações de scafoold
     * genéricas para todos os controllers filho.
     */
    use \actions\Crud;
    // use \middleware\RequestValidations;

    /**
     * Ações que serão referenciadas antes da ação requirida pela rota.
     *
     * @var array
     */
//    static $beforeAction = array('welcome');
//
//    public static function welcome() {
//        
//    }
}
