<?php

/**
 * <Encoder Framework>
 * A classe {Postgres} implementa o datasource para interação com um banco de 
 * dados Mysql. Conferir documentação dos métodos da classe Datasource
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Postgresql extends Datasource {

    #
    ##
    ###
    # BASICS #

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function databases(&$connection = 'default') {
        $sql = 'SELECT datname FROM pg_database;';

        foreach (self::query($sql, $connection) as $db)
            $dbs[] = $db['datname'];

        return @$dbs ? : array();
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function tables($connection = 'default') {
        $sql = 'SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\';';

        foreach (self::query($sql, $connection) as $table)
            $tables[] = $table['table_name'];

        return @$tables ? : array();
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columns($table, $connection = 'default') {

        $query = 'SELECT column_name FROM information_schema.columns WHERE table_name =\'' . $table . '\';';
        $query = self::query($query, $connection);

        if (!is_array($query))
            return array();

        foreach ($query as $column)
            $columns[] = $column['column_name'];

        return $columns;
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columnType($table, $column, $connection = 'default') {
        $sql = "SELECT data_type FROM information_schema.columns WHERE table_name = '$table' AND column_name = '$column';";
        $sql = self::query($sql, $connection);
        return @$sql[0]['data_type'];
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columnDescription($table, $column, $connection = 'default') {
        $sql = "        
            SELECT 
                table_name AS table,
                column_name AS column,
                column_default AS default, 
                is_nullable AS nullable,
                is_updatable AS updatable,
                data_type AS type,
                character_maximum_length AS max_length,
                numeric_precision_radix AS precision
            FROM information_schema.columns 
            WHERE table_name = '$table' AND column_name = '$column';";

        $sql = self::query($sql, $connection);
        return @$sql[0];
    }

}
