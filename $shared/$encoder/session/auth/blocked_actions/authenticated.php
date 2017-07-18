<?php

/**
 * <Encoder Framework>
 * A Trait {auth/Utils} representa o conjunto de ações controladoras que são
 * comunente bloqueadas à usuário autenticados do sistema.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace auth;

trait BlockedActionsAuthenticated {

    /**
     * @blockedAction
     */
    public static function sign_in() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function help_confirm_account() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function confirm_account() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function help_password_renew() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function help_unlock_account() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function unlock_account() {
        go();
    }

}
