<?php

/**
 * <Encoder Framework>
 * A classe {Mysql} implementa o datasource para interação com um banco de 
 * dados Mysql. Conferir documentação dos métodos da classe {Datasource}.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Mysql extends Datasource {

    #
    ##
    ###
    # BASICS #

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function databases(&$connection = 'default') {
        $s = 'SHOW DATABASES;';

        foreach (self::query($s, $connection) as $d)
            $ds[] = $d['Database'];

        return @$ds ? : array();
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function tables($connection = 'default') {
        $s = 'SHOW TABLES;';

        $d = Connection::get($connection);

        foreach (self::query($s, $connection) as $t)
            $ts[] = $t['Tables_in_' . $d['database']];

        return @$ts ? : array();
    }

    /**
     * @override 
     * Documentação em Datasource
     */
    public static function columns($table, $connection = 'default') {
        $s = 'SHOW COLUMNS FROM ' . $table;

        foreach (self::query($s, $connection) as $t)
            $c[] = $t['Field'];

        return @$c ? : array();
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
