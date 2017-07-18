<?php

/**
 * <Encoder Framework>
 * A classe {auth\Controller} tem como objetivo desempenhar atividades voltadas
 * às controladoras de usuários do sistema. Ou seja, ao extender à um {controller}
 * filho a classe {auth\Controller}, este {controller} agora representa uma
 * área de controle dos usuários sistema de autentição.
 *
 * A classe é abstrata e estática pois em nenhum momento será necessária sua
 * independente instanciação.
 *
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace auth;

abstract class Controller extends \Controller {

    /**
     * Ação responsável por renderizar a página e
     * efetuar a Conexão de um usuário no sistema.
     *
     * @unauthenticatedAction
     */
    public static function sign_in() {
        $u = auth_request();

        if (!$u->nil()) {
            if ($u->valid()) {

                $code = $u->login();

                if ($code == 0 || $code == -2)
                    flash('Combinação de e-mail e senha inválida.', 'error');
                else if ($code == -1) {
                    
                    $u::first(array(
                        'fields' => 'email, hash_password_renew',
                        'where' => "email = '$u->email'"
                    ))->emailPasswordRenew() ?
                        flash('Sua senha inspirou, enviamos um e-mail para <b>' . $u->email . '</b> com as instruções para você criar uma nova senha.') :
                        flash('Não foi possível lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error');
                    
                    go();
                } else if ($code == -3)
                    flash('Sua conta não foi confirmada.', 'warning');
                else if ($code == -4)
                    flash('Sua conta está inativa.', 'warning');
                else if ($code == -5)
                    flash('Sua conta está bloqueada.', 'warning');
                else if ($code == -6)
                    flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
                else {
                    flash('Sucesso! Você entrou no sistema.');
                    go_auth();
                }
            } else
                flash('Verifique os dados do formulário.', 'error');
        }

        set('user', $u);
    }

    /**
     * Ação responsável por renderizar a página e
     * efetuar o Cadastro de um usuário no sistema.
     *
     * @unauthenticatedAction
     */
    public static function sign_up() {
        # obtendo model da requisição
        $u = auth_request();

        if (!$u->nil()) {
            if ($u->valid()) {
                if ($u->save()) {
                    if ($u->emailConfirmAccount()) {
                        flash('Enviamos um e-mail para <small><b>' . $u->email . '</b></small> com as instruções para você confirmar sua conta.');

                        # se for um usuário não atenticado, lhe daremos uma msg mais elaborada
                        if (static::nameOfSpace() == \Auth::defaultHierarchy())
                            render(hierarchy() . '/users/confirm_account', hierarchy(), array('user' => $u));
                        else
                            go_paginate();
                    } else {
                        $u->remove();
                        flash('Não possível foi lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error') & go();
                    }
                } else {
                    flash('Não possível criar seu registro neste momento. Por favor, tente novamente mais tarde.', 'error') & go();
                }
            } else
                flash('Verifique os dados do formulário.', 'error');
        }

        set('user', $u);
    }

    /**
     * Ação responsável por renderizar a página e enviar
     * um novo email para o usuário Confirmar sua Conta.
     *
     * @unauthenticatedAction
     */
    public static function not_receive_confirmation() {
        # obtendo model da requisição
        $u = auth_request();

        if (!$u->nil()) {
            if ($u->valid()) {

                # Pra obtermos os dados básicos do usuário (nome,
                # email, ...) no objeto, buscamos seu o registro no banco.
                $u = $u::first(array(
                            'fields' => 'email, hash_confirm_account',
                            'where' => "email = '$u->email'"
                ));

                $code = $u->emailConfirmAccount();
                if ($code === -3)
                    flash_w('Sua conta já está confirmada, basta acessá-la.');
                else if ($code == true)
                    flash('Enviamos um e-mail para <small><b>' . $u->email . '</b></small> com as instruções para você confirmar sua conta.');
                else
                    flash_e('Não foi possível lhe enviar o e-mail. Por favor, tente novamente mais tarde.');

                go('/');
            } else
                flash_e('Verifique os dados do formulário.');
        }

        set('user', $u);
    }

    /**
     * Ação responsável por Confirmar a Conta de um
     * usuário através do endereço enviado ao seu email.
     *
     * @unauthenticatedAction
     */
    public static function confirm_account() {
        # hash GET param exists
        if ($hash = data('hash')) {
            $hash = \Auth::confirmAccount($hash);

            if ($hash === -3)
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
            else if ($hash === true)
                flash('Conta Confirmada! Agora você já pode se conectar.');
        }

        go();
    }

    /**
     * Ação responsável por renderizar a página e enviar um email
     * para o usuário com instruções para ele Criar uma Nova Senha.
     *
     * @unauthenticatedAction
     */
    public static function forgot_password() {
        # obtendo model da requisição
        $u = auth_request();

        if (!$u->nil()) {
            if ($u->valid()) {

                # Pra obtermos os dados básicos do usuário (nome,
                # email, ...) no objeto, buscamos seu o registro no banco.
                $auth_model = auth_model();
                $u = $auth_model::first(array(
                            'fields' => 'email, hash_password_renew',
                            'where' => "email = '$u->email'"
                ));

                $u->emailPasswordRenew() ?
                                flash('Enviamos um e-mail para <small><b>' . $u->email . '</b></small> com as instruções para você criar uma nova senha.') :
                                flash('Não foi possível lhe enviar o e-mail. Por favor, tente novamente mais tarde.', 'error');

                go();
            } else
                flash('Verifique os dados do formulário.', 'error');
        }

        set('user', $u);
    }

    /**
     * Ação responsável por rederizar a página e possíbilitar
     * a Renovação da Senha de um usuário. Acessada atravéz do
     * email enviado pela área de "esqueci minha senha".
     *
     * @unauthenticatedAction
     */
    public static function password_renew() {
        # verificando se ah uma hash de parâmetro na requisição atual
        if (!$hash = data('hash'))
            go();

        # Pra obtermos os dados básicos do usuário (nome,
        # email, ...) no objeto, buscamos seu o registro no banco.
        $u = auth_model();
        $u = $u::first(array(
                    'fields' => 'id, email, hash_password_renew',
                    'where' => 'hash_password_renew = \'' . $hash . '\''
        ));

        # verificando se foi encontrado um usuário com a hash da requisição.
        if (empty($u))
            go('/');

        $request_user = auth_request();

        # verificando se o formulário com novas senhas foi enviado.
        if (!$request_user->nil()) {
            $u->password = $request_user->password;
            $u->password_confirm = $request_user->password_confirm;

            # efetuando validações antes de salvar
            if ($u->valid()) {
                $u->passwordEdit($u->password) ?
                                flash('Sua senha foi renovada com sucesso.') :
                                flash('Algo ocorreu errado. Tente novamente mais tarde', 'error');

                go();
            } else
                flash('Verifique os dados do formulário.', 'error');
        }

        set('user', $u);
    }

    /**
     * Ação responsável por renderizar a página e enviar um email
     * para o usuário com instruções para ele Desbloquear sua conta.
     *
     * @unauthenticatedAction
     */
    public static function help_unlock_account() {
        # obtendo model da requisição
        $u = auth_request();

        if (!$u->nil()) {
            if ($u->valid()) {

                # Pra obtermos os dados básicos do usuário (nome,
                # email, ...) no objeto, buscamos seu o registro no banco.
                $model = auth_model();
                $u = $model::first(array(
                            'fields' => 'email, name, hash_unlock_account, login_attempts',
                            'where' => 'email = \'' . $u->email . '\''
                ));

                $code = $u->emailUnlockAccount();
                if ($code === -2)
                    flash('Sua conta não está bloqueada.', 'warning');
                else if ($code === true)
                    flash('Enviamos um email para <small><b>' . $u->email . '</b></small> com as instruções para Desbloquear a conta.');
                else
                    flash('Não foi possível desbloquear sua conta neste momento. Por favor, tente mais tarde.', 'error');

                go();
            } else
                flash('Verifique os dados do formulário.', 'error');
        }

        render(hierarchy() . '/users/unlock_account', hierarchy(), array('user' => $u));
    }

    /**
     * Ação responsável por Desbloquear a Conta de um
     * usuário através do endereço enviado ao seu email.
     *
     * @unauthenticatedAction
     */
    public static function unlock_account() {
        if ($hash = data('hash')) {
            $hash = unlock_account($hash);

            if ($hash === true)
                flash('Conta Desbloqueada! Agora você já pode se conectar.');
        }

        go();
    }

    /**
     * Ação de boas vindas.
     *
     * @unauthenticatedAction
     */
    public static function hello() {
        
    }

    /**
     * Ação para desconectar um usuário.
     *
     * @unauthenticatedAction
     */
    public static function logout() {
        logout();
        go();
    }

    /**
     * Ação para vefiricar se o ID enviado por post pertendo ah algum usuário.
     *
     * @before_action
     */
    protected function check_record_existence() {
        $auth_model = auth_model();

        if ($u = auth_request()) {
            if (!$auth_model::exists('id = \'' . $u->id . '\''))
                flash('Registro não encontrado. #' . $u->id, 'error') & go_paginate();

            return $u;
        }
    }

    /**
     * Send email to password renew.
     *
     * @authenticateAction
     */
    public static function email_password_renew() {
        if ($u = static::check_record_existence()) {

            $m = auth_model();
            $u = $m::first(array('where' => 'id = \'' . $u->id . '\''));

            if ($u->emailPasswordRenew())
                flash('Email com as instruções para Renovação de senha enviado para ' . $u->email . '.');
            else
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
        }

        go_paginate();
    }

    /**
     * Send email to confirm account.
     *
     * @authenticateAction
     */
    public static function email_confirm_account() {

        if ($u = static::check_record_existence()) {

            $m = auth_model();
            $u = $m::first(array('where' => 'id = \'' . $u->id . '\''));

            # definindo conta como não confirmada.
            $u->hash_confirm_account = $u->hash_confirm_account ?: \Security::random(32);

            if ($u->emailConfirmAccount())
                flash('Email com as instruções para Confirmação de conta para ' . $u->email . '.');
            else
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
        }

        go_paginate();
    }

    /**
     * Send email to unlock account.
     *
     * @authenticateAction
     */
    public static function email_unlock_account() {

        if ($u = static::check_record_existence()) {

            # definindo conta como não confirmada.
            $u->hash_unlock_account = \Security::random(32);
            if (!$u->edit())
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');

            $m = auth_model();
            if ($m::first(array('where' => 'id = \'' . $u->id . '\''))->emailUnlockAccount())
                flash('Email com as instruções para Desbloqueamento de conta enviado para ' . $u->email . '.');
            else
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
        }

        go_paginate();
    }

    /**
     * Active user account.
     *
     * @authenticateAction
     */
    public static function active() {
        if ($u = static::check_record_existence()) {
            $u->active = true;

            if ($u->edit())
                flash('Conta Ativada com sucesso.');
            else
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
        }

        go_paginate();
    }

    /**
     * Unactive user account.
     *
     * @authenticateAction
     */
    public static function unactive() {
        if ($u = static::check_record_existence()) {
            $u->active = false;

            if ($u->edit())
                flash('Conta Desativada com sucesso.');
            else
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
        }

        go_paginate();
    }

    /**
     * Edit user datas.
     *
     * @authenticateAction
     */
    public static function edit() {
        $m = auth_model();

        # check if user exists
        if (!$m::exists('id = \'' . ($id = data('id')) . '\''))
            flash('Registro não encontrado.', 'error') & go_paginate();

        # check if send data to edit
        if ($ur = auth_request()) {

            # add ID on data edit
            $ur->id = $id;

            # data is valid ?
            if ($ur->valid()) {

                # check if is valid password and encrypt it
                if ($ur->password)
                    $ur->password = auth_encrypt($ur->password);

                # editing data
                if ($ur->edit())
                    flash('Usuário editado com sucesso.') & go_paginate();

                flash('Erro ao salvar. Tente novamente mais tarde', 'error') & go_paginate();
            }

            # get form messages
            $ur = $ur->messages();
        }

        # find all user data to set on forms field
        $u = $m::first(array('where' => 'id = \'' . $id . '\''))->setAddressToForm();
        $u->setMessages($ur);

        set('user', $u);
    }

    /**
     * Remove user from system.
     *
     * @authenticateAction
     */
    public static function remove() {
        if ($u = static::check_record_existence()) {
            if ($u->remove())
                flash('Usuário deletado com sucesso.');
            else
                flash('Algo ocorreu errado. Tente novamente mais tarde.', 'error');
        }

        go_paginate();
    }

}
