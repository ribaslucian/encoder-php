<?php

/**
 * <Encoder Framework>
 * A classe {Url} tem como objetivo desempenhar atividades voltadas as URLs ou
 * endereços gerais do projeto.
 * 
 * Suas funcionalidades se limitão na obtenção de dados como: Endereço do 
 * servidor, da aplicação, protocolo, endereço atual, entre outras 
 * funcionalidades básicas do escopo.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Url extends Object {

    /**
     * Endereço (URL) completo atual da aplicação.
     * 
     * @var string
     */
    private static $current;

    /**
     * Protocolo de comunicação com o servidor (http, https).
     * 
     * @var string
     */
    private static $protocol;

    /**
     * Endereço base do servidor da aplicação.
     * 
     * @var string
     */
    private static $host;

    /**
     * Endereço base da aplicação.
     * 
     * @var string
     */
    private static $application;

    public static function init($data = array()) {
        # definindo o protocolo de comunicação com o servidor.
        self::$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https' : 'http';

        # definindo o endereço do servidor.
        self::$host = url_protocol() . '://' . $_SERVER['HTTP_HOST'];

        # definindo o endereço da aplicação.
        self::$application = url_host() . str_replace(INIT_FILE, '', $_SERVER['SCRIPT_NAME']);

        # definindo o endereço atual.
        self::$current = urldecode(url_host() . $_SERVER['REQUEST_URI']);
    }

    /**
     * Método Getter e Setter para o atributo {protocol}.
     * 
     * @param string $set Protocolo que deseja definir.
     * @return string
     */
    public static function protocol($set = null) {
        if ($set)
            return self::$protocol = $set;

        return self::$protocol;
    }

    /**
     * Método Getter e Setter para o atributo {host}.
     * 
     * @param string $set Host que deseja definir.
     * @return string
     */
    public static function host($set = null) {
        if ($set)
            return self::$host = $set;

        return self::$host;
    }

    /**
     * Método Getter e Setter para o atributo {current}.
     * 
     * @param string $set Endereço que deseja definir.
     * @return string
     */
    public static function current($set = null) {
        if ($set)
            return self::$current = $set;

        return self::$current;
    }

    /**
     * Método Getter e Setter para o atributo {application}.
     * 
     * @param string $set Endereço que deseja definir.
     * @return string
     */
    public static function application($set = null) {
        if ($set)
            return self::$application = $set;

        return self::$application;
    }

    /**
     * Redireciona o endereço da página atual para um novo endereço.
     * 
     * @param string $url Que deseja redirecionar
     * @return void
     */
    public static function go($url) {
        header('Location: ' . $url);
        exit();
    }

}
