<?php

/**
 * <Encoder Framework>
 * A classe {Session} tem como objetivo gerenciar todos os valores armazenados
 * na sessão do usuários atual. Escrevendo, obtendo e deletando dados.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Session extends Object {

    /**
     * Índice da aplicação na sessão do servidor. Todos os outros dados de 
     * sessão referente a está aplicação serão armazenados neste índice.
     * 
     * @var string
     */
    private static $applicationKey;

    /**
     * Inicializações lógicas estão localizadas neste método.
     * 
     * @constructStatic
     * @return void
     */
    public static function init($data = array()) {
        # Start session if not started
        if (!isset($_SESSION))
            session_start();

        self::setRequestCount();
    }

    /**
     * Método {Setter} e {Getter} genérico para o atributo {$applicationKey}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, o valor será apenas retornar.
     * 
     * @return string $set
     */
    public static function applicationKey($set = null) {
        if (empty($set))
            return self::$applicationKey;

        return self::$applicationKey = $set;
    }

    /**
     * Escreve um valor em um índice da sessão.
     * 
     * @param string $key
     * @param ? $value
     * 
     * @return void
     */
    public static function set($key, $value) {
        return $_SESSION[self::$applicationKey][$key] = $value;
    }

    /**
     * Obtém o valor de um índice da sessão.
     * Se o parâmetro {$key} for nulo, toda a sessão será retornada. 
     * Se o parâmetro {$destroy} for {true}, o índide ou toda a sessão será 
     * destruída.
     * 
     * @param string|null $key
     * @param boolean $destroy
     * 
     * @return ? Valor do índice
     */
    public static function get($key = null, $destroy = false) {
        # obtemos a sessão da aplicação atual caso esteja definida
        if (!$session = isset($_SESSION[self::$applicationKey]) ? $_SESSION[self::$applicationKey] : null)
            return null;

        if ($key !== null) # if not key, all session is getted
            $session = isset($session[$key]) ? $session[$key] : null;

        if ($destroy && $session != null)
            self::destroy($key);

        return $session;
    }

    /**
     * Destrói um índide da sessão.
     * Se o parâmetro {$key} for nulo, toda a sessão será destruída.
     * 
     * @param string $key
     * @return void
     */
    public static function destroy($key = null, $all = false) {
        if ($key == null) {
            unset($_SESSION[self::$applicationKey]);
        } else
            unset($_SESSION[self::$applicationKey][$key]);

        if ($all) {
            unset($_SESSION);
            session_destroy();
        }
    }

    /**
     * Define o contador de requisições de um cliente determinado cliente com a
     * aplicação.
     * 
     * @return void
     */
    private static function setRequestCount() {
        $request_count = self::get('request_count') ? : 0;
        self::set('request_count', $request_count + 1);
    }

    /**
     * Obtém o contador de requisições de um deterrminado cliente com a aplicação.
     * 
     * @return int
     */
    public static function requestCount() {
        return self::get('request_count');
    }

    /**
     * Método de segurançam, índice de segurança.
     * Baseado na contagem de requisições do cliente atual, é criado uma {hash}
     * única para a requisição atual, podendo alterar o índice da sessão 
     * referente ao cliente em cada requisição do mesmo.
     * 
     * @return string
     */
    public static function getCurrentAppClientToken() {
        return sha1(Session::applicationKey() . self::requestCount());
    }

    /**
     * Obtém o índice de segurança referente a requisição anterior de um 
     * determinado cliente.
     * 
     * @return string
     */
    public static function getOldAppClientToken() {
        return sha1(Session::applicationKey() . (self::requestCount() - 1));
    }

}
