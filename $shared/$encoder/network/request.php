<?php

/**
 * <Encoder Framework>
 * A classe {Request} tem como objetivo desempenhar funcionalidades voltadas à 
 * requisições efetudas do cliente para a aplicação e vice-verce. De princípio 
 * utilizando o protocolo HTTP.
 * 
 * Suas funcionalidades correspondem: Na leitura dos dados da requisição atual e 
 * na construção de chamadas utilizando os métodos {GET} e {POST}; Na identificação
 * do cliente requisitor; Na descrição, identificação e validação da requisição atual;
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
class Request extends Object {

    /**
     * IP públic do cliente dono da requisição atual.
     * 
     * @var string
     */
    private static $ip;

    /**
     * Na primeira chamada o método define e retorna o atributo {ip}. Nas 
     * próximas, para poupar reprocessamento ele apenas retorna o valor do
     * atributo {ip}.
     * 
     * @return string
     */
    public static function ip() {
        if (!empty(self::$ip))
            return self::$ip;

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return self::$ip = $ip;
    }

    /**
     * Na tentativa de obter o nome do computador dono da requisição, obtemos
     * um identificador do cliente diferente do {IP} público, mas o nome do 
     * cliente dentro da rede pública.
     * 
     * @return string
     */
    public static function clientName() {
        return gethostbyaddr($_SERVER['REMOTE_ADDR']);
    }

    /**
     * Verifica se a chamada atual na aplicação está sendo efetuada através da
     * tecnologia {AJAX}.
     * 
     * @return boolean
     */
    public static function isAjax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            return true;

        return false;
    }

    /**
     * Obtém um valor passado do cliente para 
     * a aplicação através do método {GET}.
     * 
     * - Na ausência do parâmetro {$key} o método irá retornar todo o contéudo
     * presente no {GET} passado do cliente para a requisição atual.
     * - Caso {$key} seja informado, o método irá buscar por um índice nos 
     * valores {GET}, caso o encontre, retornará seu valor, se não retornará 
     * {null}.
     * 
     * @param string $key
     * @return array / ? / null
     */
    public static function get($key = null) {
        if ($key === null)
            return $_GET;

        return array_key_exists($key, $_GET) ? $_GET[$key] : null;
    }

    /**
     * Obtém um valor passado do cliente para 
     * a aplicação através do método {POST}.
     * 
     * - Na ausência do parâmetro {$key} o método irá retornar todo o contéudo
     * presente no {POST} passado do cliente para a requisição atual.
     * - Caso {$key} seja informado, o método irá buscar por um índice nos 
     * valores {POST}, caso o encontre, retornará seu valor, se não retornará 
     * {null}.
     * 
     * @param string $key
     * @return array / ? / null
     */
    public static function post($key = null) {
        if ($key === null)
            return $_POST;

        return array_key_exists($key, $_POST) ? $_POST[$key] : null;
    }

    /**
     * Método genérico para buscar um parâmetro passado do usuário para a 
     * aplicação através dos métodos {GET} e {POST}. 
     * Caso o usuário não informe o método que deseja dar prioridade, será 
     * buscado primeiramente nos parâmetros {GET}.
     * 
     * Este método se basea nos método adjacentes {post/get}.
     * 
     * @param string $key
     * @param string $method null / get / post
     * 
     * @return array / null / ?
     */
    public static function param($key = null, $method = null) {
        if ($method == 'get')
            return static::get($key);

        if ($method == 'post')
            return static::post($key);

        $value = static::get($key);

        if (empty($value))
            return static::post($key);

        return $value;
    }

    /**
     * Caso necessário, gerá um código {CSFR} e armazena o mesmo na sessão. Se
     * já existir um código {CSFR} não validado na sessão, o método apenas o 
     * manterá.
     * 
     * @return string Token válido da requis~~ao
     */
    public static function csfr() {
        $csfr = Session::get('csfr');
        $ip = Request::ip();

        # caso já exista uma CSFR não verificada vamos utilizar.
        if (isset($csfr[$ip]))
            return $csfr[$ip];

        # criamos uma nova CSFR.
        Session::set('csfr', array(
            $ip => ($token = Security::random())
        ));

        return $token;
    }

    /**
     * A partir de um código {CSFR} enviado por {GET/POST}
     * O método vai verifica se é ou não um código válido, solicidado pela 
     * requisição anterior a atual.
     * 
     * @return boolean
     */
    public static function csfrValid($csfr = null, $method = 'post') {
        $csfr = $csfr ? : static::$method('csfr');

        $session_csfr = Session::get('csfr');

        # verificamos se há algum CSFR definido no IP atual.
        if (!$session_csfr = $session_csfr[ip()])
            return false;

        # destruimos a CSFR utilizada anteriormente
        Session::destroy('csfr');

        # verificamos se a CSFR obtida é igual da da Requisição.
        return $session_csfr == $csfr ? true : false;
    }

    /**
     * Obtém o nome do computador do cliente.
     * 
     * @return string
     */
    public static function getClientName() {
        return gethostbyaddr($_SERVER['REMOTE_ADDR']);
    }

    /**
     * Constrói um {query} válido e concatenável a {URL}.
     * 
     * @param string $key chave que deseja sobreescrever
     * @param string $value valor que deseja inserir na chave
     * @return string {query}
     */
    public static function query($key = null, $value = null) {
        $get = $_GET;

        if ($key !== null && $value !== null)
            $get[$key] = $value;

        return http_build_query($get);
    }

}
