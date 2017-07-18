<?php

/**
 * <Encoder Framework>
 * A classe {Connection} tem como objetivo gerenciar as conexões de bancos de 
 * dados definidas na aplicação. Gerenciando suas aberturas/fechamentos e 
 * armazenando seus parâmentros.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Connection extends Object {

    /**
     * Configuraçoes padrão para uma conexão com um banco de dados.
     * 
     * @var array
     */
    public static $defaults = array(
        'source' => 'Postgresql',
        # 'path' => '', # for SQLite
        'host' => 'localhost',
        'port' => 5432,
        'user' => 'postgres',
        'password' => 'postgres',
        'database' => 'postgres',
        'encoding' => 'utf8',
    );

    /**
     * Configurações de conexões com os bancos de dados da aplicação.
     * Denindo {alias, host, user, password, database, source, etc...}
     * 
     * @var array
     */
    public static $connections = array();

    /**
     * Método {Setter} e {Getter} genérico para o atributo {connections}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, o valor será apenas retornado.
     * 
     * @return string $key
     */
    public static function connections($set = null) {
        if (empty($set))
            return self::$connections;

        return self::$connections = $set;
    }

    /**
     * Obtém todos os parâmetros de um conexão, inclusive seus dados reais da 
     * conexão, caso ela esteja aberta.
     * Se não for informado qual conexão deseja obter, todas serão retornadas.
     * 
     * @param string $connection
     * @return array
     */
    public static function get($connection = null) {
        if (empty($connection))
            return static::$connections;

        if (!array_key_exists($connection, static::$connections))
            throw new MissingConnection('Missing Connection "' . $connection . '"');

        return static::$connections[$connection] = @array_merge(self::$defaults, self::$connections[$connection]);
    }

    /**
     * Obtem o {datasource} configuração em uma determinada conexão.
     * 
     * @param string $connection
     * @return string
     */
    public static function datasource($connection = 'default') {
        $connection = self::get($connection);
        return @$connection['source'];
    }

}
