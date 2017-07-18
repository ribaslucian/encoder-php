<?php

/**
 * <Encoder Framework>
 * A classe {Db/Database} tem como objetivo implementar uma interface genérica 
 * de comunicação com os bancos de dados definidos nas conexões da aplicação, 
 * atravéz da classe {Connection}. Tornando desnecessário a comunicação direta 
 * com os {datasources} configurados.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Db extends Object {

    #
    ##
    ###
    # BASICS #

    /**
     * Nome da conexão que será utilizada nas interações com os bancos de dados.
     * Este valor pode ser alterado pelo método {connection} ou ser redefinido
     * em cada interação.
     * 
     * @var string
     */
    private static $connection = 'default';

    /**
     * Nome da table que será utilizado nas interações com os bancos de dados.
     * Este valor pode ser alterado pelo método {table} ou ser redefinido
     * em cada interação.
     * 
     * @var string
     */
    private static $table;

    /**
     * Método {Setter} e {Getter} genérico para o atributo {connection}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, o valor será apenas retornado.
     * 
     * @return string $key
     */
    public static function connection($set = null) {
        if (!empty($set))
            return self::$connection = $set;

        return self::$connection;
    }

    /**
     * Método {Setter} e {Getter} genérico para o atributo {connection}.
     * Ao informar o parâmetro {$set} o método irá definir e retornar o valor.
     * Se não, o valor será apenas retornado.
     * 
     * @return string $key
     */
    public static function table($set = null) {
        if (!empty($set))
            return self::$table = $set;

        return self::$table;
    }

    /**
     * @docs in {Datasource}.
     */
    public static function query($sql, $conn = 'default') {
        # redefindo atributos {connection} caso informado.
        $a = array('@connection' => $conn);
        static::setProperties($a);

        # obtendo o datasource referente a conexão definido no momento.
        $d = Connection::datasource($conn);

        return $d::query($sql, $conn);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     */
    public static function databases($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::databases(static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * Índice @connection pra definir qual conexão que será utilizada.
     */
    public static function tables($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);
        return $datasource::tables(static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     */
    public static function columns($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::columns(static::$table, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     * @param array $options Índice column Pra definir qual coluna será referenciada.
     */
    public static function columnType($options = array()) {
        array_required_index($options, array('column'));

        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::columnType(static::$table, $options['column'], static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     * @param array $options Índice column Pra definir qual coluna será referenciada.
     * Opções: table, column, default, nullable, updatable, type, max_length, precision
     * 
     * @param array $options Índice option Opção que deseja obter da coluna.
     */
    public static function columnDescription($options = array()) {
        array_required_index($options, array('table', 'column'));

        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $d = Connection::datasource(static::$connection);

        # obtendo descrição da coluna
        # table, column, default, nullable, updatable, type, max_length, precision
        $d = $d::columnDescription(static::$table, $options['column'], static::$connection);

        if (isset($options['option']))
            return $d[$options['option']];

        return $d;
    }

    #
    ##
    ###
    # CRUD #

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     */
    public static function select($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);
        
        return $datasource::select($options, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     */
    public static function insert($records = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($records, true);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::insert(static::$table, $records, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     * @param array $options Índice @where para condições de atualização.
     * 
     * '@where' => array('conditions');
     */
    public static function update(array $data) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($data, true);

        # definindo condições de atualização
        $where = '';
        if (isset($data['@where'])) {
            $where = $data['@where'];
            unset($data['@where']);
        }

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::update(static::$table, $data, $where, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     * @param array $options Índice where para condições de atualização.
     * 
     * 'where' => array('conditions');
     */
    public static function delete($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options, true);
        
        static::$table = is_string($options) ? $options : static::$table;

        # definindo condições de atualização
        $where = '';
        if (isset($options['where'])) {
            $where = $options['where'];
            unset($options['where']);
        }

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::delete(static::$table, $where, static::$connection);
    }

    #
    ##
    ###
    # UTILITY #

    /**
     * @docs in {Datasource}.
     * 
     * @param string $connection Conexão que será utilizada.
     */
    public static function lastError($connection = 'default') {
        $d = Connection::datasource($connection);
        return $d::lastError($connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     */
    public static function first($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::first(static::$table, $options, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     */
    public static function newId($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options, true);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::newId(static::$table, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection pra definir qual conexão que será utilizada.
     * @param array $options Índice @table pra definir qual table que será utilizada.
     * @param array $options Índice where para condições de atualização.
     */
    public static function count($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options, true);

        # definindo condições para contagem caso tenha.
        $where = array();
        if (isset($options['where'])) {
            $where = $options['where'];
            unset($options['where']);
        }

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);
        return $datasource::count(static::$table, $where, static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection Pra definir qual conexão que será utilizada.
     * @param array $options Índice @table Pra definir qual table que será utilizada.
     * @param array $options Índice column Pra definir qual column será referenciada
     * @param array $options Índice value Pra definir o valor da coluna
     * @param array $options Índice options Pra definir mais opções na busca
     */
    public static function byColumn($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options, true);

        array_required_index($options, array('column', 'value'));

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::byColumn(
            static::$table, $options['column'], $options['value'], @$options['options'], static::$connection
        );
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection Pra definir qual conexão que será utilizada.
     * @param array $options Índice @table Pra definir qual table que será utilizada.
     * @param array $options Índice id Para referenciar o registro
     */
    public static function byId($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options, true);

        array_required_index($options, array('id'));

        $options['column'] = 'id';
        $options['value'] = $options['id'];
        return static::byColumn($options);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param array $options Índice @connection Pra definir qual conexão que será utilizada.
     * @param array $options Índice @table Pra definir qual table que será utilizada.
     * @param array $options Índice where para condições de atualização.
     */
    public static function exists($options = array()) {
        # redefindo atributos {database} e {connection} caso informado.
        static::setProperties($options, true);

        # obtendo o datasource referente a conexão definido no momento.
        $datasource = Connection::datasource(static::$connection);

        return $datasource::exists(static::$table, @$options['where'], static::$connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param string $connection Conexão que será utilizada.
     */
    public static function begin($connection = 'default') {
        $d = Connection::datasource(static::$connection);
        return Db::query($d::begin(), $connection);
    }

    /**
     * @docs in {Datasource}.
     * 
     * @param string $connection Conexão que será utilizada.
     */
    public static function commit($connection = 'default') {
        $d = Connection::datasource(static::$connection);
        return Db::query($d::commit(), $connection);
    }

}
