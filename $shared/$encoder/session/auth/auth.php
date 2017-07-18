<?php

/**
 * <Encoder Framework>
 * A classe {Auth} tem como objetivo desempenhar atividades aos usuário do
 * sistema. Autenticados ou não, a classe fornece funcionalidades para vários
 * requisitos de autenticação.
 *
 * A classe é abstrata e estática pois em nenhum momento será necessária sua
 * independente instanciação.
 *
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Auth extends Object {
    #
    ##
    ###
    # BASICS #

    /**
     * Nome of the class Model of the Users Table.
     *
     * @var string
     */
    private static $model;

    /**
     * User hierarchy name when disconnected.
     *
     * @var string
     */
    private static $defaultHierarchy; # unconnected hierarchy name

    /**
     * Max user login attempts.
     *
     * @var int
     */
    private static $maxLoginAttempts = 5;

    /**
     * Password Encrypt Method
     *
     * @var function($pasword)
     */
    private static $encryptMethod;

    /**
     * Table fields that will be save on Session.
     *
     * @var string
     */
    private static $sessionFields;

    /**
     * Session index that will save the user fields.
     *
     * @var string
     */
    private static $sessionKey;

    /**
     * Model Getter & Setter.
     *
     * @param string $set
     */
    public static function model($set = null) {
        if (empty($set))
            return self::$model;

        return self::$model = $set;
    }

    /**
     * Session Key Getter & Setter.
     *
     * @param string $set
     */
    public static function sessionKey($set = null) {
        if (empty($set))
            return self::$sessionKey;

        return self::$sessionKey = $set;
    }

    /**
     * Session Fields Getter & Setter.
     *
     * @return string $set
     */
    public static function sessionFields($set = null) {
        if (empty($set))
            return self::$sessionFields;

        return self::$sessionFields = $set;
    }

    /**
     * Default Hierarchy Getter & Setter.
     *
     * @param string $set
     */
    public static function defaultHierarchy($set = null) {
        if (empty($set))
            return self::$defaultHierarchy;

        return self::$defaultHierarchy = $set;
    }

    /**
     * Max Login Attempts Getter & Setter.
     *
     * @param int $set
     */
    public static function maxLoginAttempts($set = null) {
        if (empty($set))
            return self::$maxLoginAttempts;

        return self::$maxLoginAttempts = $set;
    }

    /**
     * Encrypt Method Getter & Setter.
     *
     * @param function($password) $encryptMethod
     */
    public static function encryptMethod($set = null) {
        if (empty($set))
            return self::$encryptMethod;

        return self::$encryptMethod = $set;
    }

    /**
     * Encrypt Password by defined method.
     *
     * @return string password encrypted
     */
    public static function passwordEncrypt($password) {
        $em = self::$encryptMethod;

        if (empty($em) || !is_callable($em))
            return $password;

        return $em($password);
    }

    /**
     * Verifica os dados informados e tenta
     * iniciar uma sessão para o usuário correspondente.
     *
     * @param string $username
     * @param string $password
     *
     * @return int 0 Usuário não encontrado
     * @return int -1 Senha expirada
     * @return int -2 Senha inválida
     * @return int -3 Conta não confirmada
     * @return int -4 Conta desabilitada
     * @return int -5 Conta bloqueada
     * @return int -6 Erro ao interagir com o banco de dados
     * @return bolean
     */
    public static function login($username, $password) {

        # buscando usuário
        $user = '\\' . self::$model;
        $user = $user::first(array(
            'where' => array(self::$usernameField => $username)
        ));

        # não ah usuários com o email informado.
        if (empty($user))
            return 0;

        $code = 1;
        $field_password = self::$passwordField;
        $field_active = self::$activeField;

        # a senha do usuário está expirada ou foi solicitado alteração.
        if (!empty($user->hash_password_renew)) {
            ++$user->login_attempts;
            $code = -1;
        }

        # a conta do usuário está Bloqueada.
        else if ($user->login_attempts >= (self::$maxLoginAttempts - 1) || !empty($user->hash_unlock_account)) {
            # <implements{self::email_unlock_account($user)}> enviar email para desbloquear a conta.
            $user->hash_unlock_account = $user->hash_unlock_account ? : Security::random(32);
            ++$user->login_attempts;
            $code = -5;
        }

        # a senha do usuário está Inválida.
        else if ($user->$field_password != $password) {
            ++$user->login_attempts;
            $code = -2;
        }

        # a conta do usuário não está Confirmada.
        else if (!empty($user->hash_confirm_account)) {
            $code = -3;
        }

        # a conta do usuário está Desativada.
        else if ($user->$field_active === 'f' || !$user->$field_active) {
            $code = -4;
        }

        # os dados do usuário estão corretos.
        if ($code == 1) {
            $user->last_login = date('Y-m-d H:i:s');
            $user->login_attempts = 0;
            ++$user->login_count;
        } else {

            # verificando se a conta está banidada.
            if ($user->login_attempts >= 99) {
                $user->$field_active = false;
                $user->login_attempts = 99;
            }
        }

        unset($user->password);
        # atualizamos os dados do usuário no banco.
        if (!$user->edit())
            $code = -6;

        # verificamos se ocorreu algum erro.
        if ($code <= 0)
            return $code;

        # definindo dados que serão salvos na sessão.
        $session = array();
        foreach (explode(',', self::$sessionFields) as $field) {
            $field = str_replace(' ', '', $field);
            $session[$field] = $user->$field;
        }

        # salvando dados do usuário na sessão.
        $auth = Session::get('auth') ? : array();
        $auth[self::$sessionKey] = (object) $session;
        return Session::set('auth', $auth);
    }

    /**
     * Destrói a sessão do usuário conectado.
     *
     * return bool
     */
    public static function logout() {
        return Session::destroy('auth');
    }

    /**
     * Obtém um ou todos os campos da sessão do usuário.
     *
     * @param string $field
     * @return ?
     */
    public static function field($field = null) {
        $auth = Session::get('auth');

        if ($auth == null || !isset($auth[self::$sessionKey]))
            return null;

        if ($field != null && isset($auth[self::$sessionKey]->$field))
            return $auth[self::$sessionKey]->$field;

        return $auth[self::$sessionKey];
    }

    /**
     * Obtém a hierarquia do usuário atual.
     *
     * @return string
     */
    public static function hierarchy() {
        return self::field('hierarchy') ? : self::$defaultHierarchy;
    }

    #
    ##
    ###
    # EMAILS #

    /**
     * Envia um email para o usuário com as
     * instruções para ele criar uma nova senha.
     *
     * @param string $email
     *
     * @return int -1 erro ao salvar no banco
     * @return int -2 usuário não encontrado
     * @return bool email enviado ou não
     */
    public static function emailPasswordRenew($email) {
        $u = self::$model;
        $u = $u::first(array(
                    'fields' => 'name, email, hash_password_renew',
                    'where' => array('email' => $email)
        ));

        if (empty($u))
            return -2;

        return $u->emailPasswordRenew();
    }

    /**
     * Envia um email para o usuário com as
     * instruções para ele Confirmar sua conta.
     *
     * @param string $email
     *
     * @return int -1 erro ao salvar no banco
     * @return int -2 usuário não encontrado
     * @return int -3 conta já esta confirmada
     * @return bool email enviado ou não
     */
    public static function emailConfirmAccount($email) {
        $u = self::$model;
        $u = $u::first(array(
                    'fields' => 'name, email, hash_confirm_account',
                    'where' => 'email = \'' . $email . '\''
        ));

        if (empty($u))
            return -2;

        return $u->emailConfirmAccount();
    }

    /**
     * Envia um email para o usuário com as
     * instruções para ele Desbloquear sua conta.
     *
     * @param string $email
     *
     * @return int -1 erro ao salvar no banco
     * @return int -2 conta não está bloqueada
     * @return int -3 conta já está confirmada
     * @return bool email enviado ou não
     */
    public static function emailUnlockAccount($email) {
        $u = self::$model;
        $u = $u::first(array(
                    'fields' => 'id, name, email, login_attempts',
                    'where' => 'email = \'' . $email . '\''
        ));

        # user not found
        if (empty($u))
            return -1;

        return $u->emailUnlockAccount();
    }

    #
    ##
    ###
    # DATABASE #

    /**
     * Table field that represents the username.
     *
     * @var string
     */
    private static $usernameField;

    /**
     * Table field that represents the password of user.
     *
     * @var string
     */
    private static $passwordField;

    /**
     * Table field that represents if user is active.
     *
     * @var string
     */
    private static $activeField;

    /**
     * Username Field Getter & Setter.
     *
     * @param string $set
     */
    public static function usernameField($set = null) {
        if (empty($set))
            return self::$usernameField;

        return self::$usernameField = $set;
    }

    /**
     * Password Field Getter & Setter.
     *
     * @param string $set
     */
    public static function passwordField($set = null) {
        if (empty($set))
            return self::$passwordField;

        return self::$passwordField = $set;
    }

    /**
     * Active Field Getter & Setter.
     *
     * @param string $set
     */
    public static function activeField($set = null) {
        if (empty($set))
            return self::$activeField;

        return self::$activeField = $set;
    }

    /**
     * Edita a senha de um usuário atravéz do seu email.
     *
     * @param string $email
     * @param string $password
     *
     * @return integer -1 Usuário não encontrado
     * @return integer -2 Erro ao interagir com banco de dados
     */
    public static function passwordEdit($email, $password) {
        $u = self::$model;
        $u = $u::first(array(
                    'fields' => 'id',
                    'where' => 'email = \'' . $email . '\''
        ));

        # user not found
        if (empty($u))
            return -1;

        return $u->editPassword($password);
    }

    /**
     * Confirma a conta de um usuário baseado na sua {hash} para confirmação
     * de conta.
     *
     * @param string $hash
     *
     * @return int -1 Usuário não encontrado
     * @return int -2 Conta já confirmada
     * @return int -3 Erro ao interagir com banco de dados
     * @return bolean
     */
    public static function confirmAccount($hash) {
        $u = self::$model;
        $u = $u::first(array(
                    'fields' => 'id, email, hash_confirm_account',
                    'where' => 'hash_confirm_account = \'' . $hash . '\''
        ));

        # usuário não encontrado
        if (empty($u))
            return -1;

        return $u->confirmAccount();
    }

    /**
     * Desbloqueia a conta de um usuário através do sua hash de desbloqueio.
     *
     * @param $hash
     *
     * @return int -1 usuário não encontrado
     * @return int -2 erro ao salvar no banco
     * @return bolean
     */
    public static function unlockAccount($hash) {
        $u = self::$model;

        $u = $u::first(array(
                    'fields' => 'id, name, email, login_attempts',
                    'where' => 'hash_unlock_account = \'' . $hash . '\''
        ));

        if (empty($u))
            return -1;

        return $u->unlockAccount();
    }

    #
    ##
    ###
    # UTILS #

    /**
     * Ao chamar este método nas configurações da classe {Auth}, será utilizado
     * um índice seguro para os dados de autenticão do usuário. Ou seja, a cada
     * requisição do usuário, seu índice na sessão será auterado para um outra
     * {hash} única.
     *
     * @return void
     */
    public static function useSecurityKey() {
        $new_key = \Session::getCurrentAppClientToken();
        self::sessionKey($new_key);

        $auth = \Session::get('auth');

        # verificamos se existe algum valor de autenticador registrado
        if (is_array($auth)) {

            # verificamos se existe uma cache pra requisição anterior
            $old_key = \Session::getOldAppClientToken();

            if (isset($auth[$old_key])) {

                # obtemos os valores do autenticador e armazenamos em um novo índice
                $auth[$new_key] = $auth[$old_key];

                # destruímos os valores do índice antigo
                unset($auth[$old_key]);

                # salvamos na sessão os valores do autenticador atualizado
                \Session::set('auth', $auth);
            }
        }
    }

    /**
     * Redirecionar a rota sem sair do pacote definido como hierarquia a
     * do usuário atual.
     *
     * @param string $route
     * @return void
     */
    public static function redirect($route = '') {
        \Route::redirect('/' . self::hierarchy() . $route);
    }

    /**
     * Redirecionar a rota sem sair do pacote definido como hierarquia a
     * do usuário atual.
     *
     * @param string $route
     * @return void
     */
    public static function url($route = '') {
        return \Route::url('/' . self::hierarchy() . $route);
    }

    /**
     * Através dos dados da requisição, obtemos
     * a instância do modelo referente a tabela de usuário.
     *
     * @return encoder\Model
     */
    public static function request() {
        return model_request('\\' . self::getRequiredProperty('model'));
    }

    public static function allowIfMyArea() {
        $namespace = route_controller();
        $namespace = $namespace::nameOfSpaceAlias();

        # verificamos se o namespace de acesso atual corresponde a sua hierarquia
        if ($namespace != hierarchy())
            go_auth();
    }

}
