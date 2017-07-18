<?php

/**
 * <Encoder Framework>
 * A classe {auth\Model} tem como objetivo desempenhar atividades voltadas à 
 * interação com entitidades instânciadas referentes ao componente de 
 * autenticação. Ou seja, ao extender à um modelo filho a classe {auth\Model},
 * este modelo agora representa um usuário qualquer do sistema de autentição.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */

namespace auth;

abstract class Model extends \encoder\Model {

    /**
     * Definimos que a tabela 'users' como armazenadora dos registros de usuários.
     * 
     * @var string
     */
    static $table = 'users';

    /**
     * Validações de objetos auth\Model em determinadas ações do sistema.
     * 
     * @var array
     */
    static $validate = array(
        'notEmpty {email, password} {sign_in, add, edit}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {email} {sign_in, add, edit, not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 92
        ),
        'strmin {email} {sign_up, add, edit, not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'email {email} {sign_up, add, edit, not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Este email não é válido.'
        ),
        'unique {email} {sign_up, add, edit}' => array(
            'Já existe um registro com este valor.'
        ),
        'exists {email} {not_receive_confirmation, forgot_password, help_unlock_account}' => array(
            'Não há registro com este e-mail.'
        ),
        'notEmpty {password} {sign_in, add, edit, password_renew, password_expired, sign_up}' => array(
            'É obrigatório preencher este campo.',
        ),
        'strmax {password} {add, edit, password_renew, password_expired, sign_up, add, edit}' => array(
            'Insira no máximo :max caracteres.',
            'max' => 32
        ),
        'strmin {password} {sign_in, add, edit, password_renew, password_expired, sign_up}' => array(
            'Insira no mínimo :min caracteres.',
            'min' => 5
        ),
        'confirm {password_confirm} {password_renew, password_expired, sign_up, add, edit}' => array(
            'As senhas não conferem.',
            'compare_to' => 'password'
        ),

        # forgot_password
        'notEmpty {email} {forgot_password}' => array(
            'É obrigatório preencher este campo.',
        ),
        
        # not_receive_confirmation
        'notEmpty {email} {not_receive_confirmation}' => array(
            'É obrigatório preencher este campo.',
        )
    );

    /**
     * Métodos referenciados durante as interações com os objetos auth\Model.
     * 
     * @var array
     */
    static $event = array(
        'before:save' => array('typograph', 'encryptPassword', 'setUnconfirmedAccount'),
        'before:edit' => array('typograph'),
    );

    /**
     * Antes de salvar/editar um registro de usuário no banco vamos 
     * deixar maíusculo o que deve ser maíusculo, e minúsculo 
     * o que deve ser minúsculo, entre outras validações.
     * 
     * @event
     */
    protected static function typograph($user) {
        if (isset($user->email))
            $user->email = mb_strtolower($user->email);
    }

    /**
     * Antes de salvar um registro encripta a senha do usuário.
     * 
     * @envet
     */
    protected static function encryptPassword($user) {
        if (!empty($user->password)) {
            $user->password = auth_encrypt($user->password);
        }
    }

    /**
     * Antes de salvar um usuário vamos atribuir um valor para confirmação da sua conta.
     * 
     * @envet
     */
    protected static function setUnconfirmedAccount($user) {
        $user->hash_confirm_account = base64_encode(sha1($user->email . date('dmYHis')));
    }

    /**
     * Cria uma sessão de usuário a partir dos 
     * dados do objeto referenciador do método.
     * 
     * @return int
     */
    public function login() {
        return login($this->email, $this->password);
    }

    /**
     * Para o usuário correspondente aos dados do objeto 
     * referenciador do método, é enviado um email contendo
     * as instruções pra ele confirmar sua conta.
     * 
     * @return int -1 erro ao salvar no banco
     * @return int -3 a conta já está confirmada
     * @return bool email enviado ou não
     */
    public function emailConfirmAccount() {
        # conta já está confirmada
        if (empty($this->hash_confirm_account))
            return -3;

        # não foi possível salvar a hash no banco de dados
        if (!$this->edit('email'))
            return -1;

        return \Mail::byView($this->email, 'Confirmar Conta', hierarchy() . '/users/mails/confirm_account', array(
            'user' => $this
        ));
    }

    /**
     * Confirma a conta do usuário correspondente
     * aos dados do objeto referenciador do método.
     * 
     * @return int -1 erro ao salvar no banco
     * @return int -2 a conta já está confirmada
     */
    public function confirmAccount() {
        # a conta já está confirmada
        if (empty($this->hash_confirm_account))
            return -2;

        $this->hash_confirm_account = '';
        if (!$this->edit('email'))
            return -1;

        return true;
    }

    /**
     * Para o usuário correspondente aos dados do objeto 
     * referenciador do método, é enviado um email contendo
     * as instruções pra ele criar uma nova senha pra sua conta.
     * 
     * @return int -1 erro ao salvar no banco
     * @return bool email enviado ou não
     */
    public function emailPasswordRenew() {
        # criamos uma hash em hash_password_renew caso o usuário ainda não tenha.
        if (empty($this->hash_password_renew))
            $this->hash_password_renew = \Security::random(32);

        if (!$this->edit('email'))
            return -1;

        return \Mail::byView($this->email, 'Renovar Minha Senha', hierarchy() . '/users/mails/password_renew', array(
            'user' => $this
        ));
    }

    /**
     * Altera a senha do usuário correspondente
     * aos dados do objeto referenciador do método.
     * 
     * @param string $password
     * 
     * @return integer -2 erro ao salvar no banco.
     */
    public function passwordEdit($password) {
        $this->password = \Auth::passwordEncrypt($password);
        $this->hash_password_renew = '';
        $this->login_attempts = 0;

        if (!$this->edit('email'))
            return -2;

        return true;
    }

    /**
     * Send email for uuser Unlock Account
     * 
     * @return int -1 erro ao salvar no banco
     * @return int -2 a conta não esta bloqueada
     * @return bool email enviado ou não
     */
    public function emailUnlockAccount() {

        # a conta não esta bloqueada
        if ($this->login_attempts <= \Auth::maxLoginAttempts() && empty($this->hash_unlock_account))
            return -2;

        # erro ao salvar no banco
        $this->hash_unlock_account = \Security::random();

        if (!$this->edit('email'))
            return -1;
        
        return \Mail::byView($this->email, 'Desbloquear Conta', hierarchy() . '/users/mails/unlock_account', array(
            'user' => $this
        ));
    }

    /**
     * Desbloqueia a conta do usuário correspondente
     * aos dados do objeto referenciador do método.
     * 
     * @param string $password
     * 
     * @return integer -2 erro ao salvar no banco.
     * @return bool conta desbloqueada
     */
    public function unlockAccount() {
        $this->hash_unlock_account = '';
        $this->login_attempts = 0;

        if (!$this->edit())
            return -2;

        return true;
    }

}
