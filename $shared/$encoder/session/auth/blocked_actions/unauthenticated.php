<?php

/**
 * <Encoder Framework>
 * A Trait {auth/Utils} representa o conjunto de ações controladoras que são
 * comunente bloqueadas à usuário não autenticados do sistema.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace auth;

trait BlockedActionsUnauthenticated {

    /**
     * @blockedAction
     */
    public static function hello() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function index() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function add() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function edit() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function remove() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function unactive() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function active() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function email_unlock_account() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function email_confirm_account() {
        go();
    }

    /**
     * @blockedAction
     */
    public static function email_password_renew() {
        go();
    }

}
