<?php

/**
 * <Encoder Framework>
 * A classe {Sqlite} implementa o datasource para interação com um banco de 
 * dados Sqlite. Conferir documentação dos métodos da classe Datasource
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Sqlite extends Datasource {

    #
    ##
    ###
    # BASICS #

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function connection($connection = 'default') {
        $config = Connection::get($connection);

        if (!array_key_exists('connection', $config)) {

            # criando arquivo do SQLite
            if (!$conn = new PDO('sqlite:' . $config['path'] . $config['database'] . '.db'))
                throw new ConnectionFailed($connection);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            Connection::$connections[$connection]['connection'] = $conn;
        }

        return Connection::$connections[$connection]['connection'];
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function tables($connection = 'default') {
        $tables_query = Sqlite::query('SELECT name FROM sqlite_master WHERE type=\'table\'', $connection);

        # encontrou alguma tabela ?
        if (!is_array($tables_query))
            return array();

        foreach ($tables_query as $t)
            $tables[] = $t['name'];

        return $tables;
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columns($table, $connection = 'default') {
        foreach (Sqlite::query('pragma table_info(' . $table . ');') as $c)
            $columns[] = $c['name'];

        return @$columns ? : array();
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function databases(&$connection = 'default') {
        return null;
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columnType($table, $column, $connection = 'default') {
        return null;
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columnDescription($table, $column, $connection = 'default') {
        return null;
    }

}
