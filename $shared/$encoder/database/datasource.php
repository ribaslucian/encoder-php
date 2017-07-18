<?php

/**
 * <Encoder Framework>
 * A classe {Connection} tem como objetivo descrever ou construir um datasource
 * válido para o framework, fornecendo as funcionalidades básicas e suas
 * determinadas interfaces. Caso deseje impletar um novo driver de banco de
 * dados basta header a classe datasource.
 *
 * A classe é abstrata e estática pois em nenhum momento será necessária sua
 * independente instanciação.
 *
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
abstract class Datasource extends Object {

    /**
     * Apelidos para os datasources durante a utilização de outros recursos
     * (geradores de query, PDO, etc...)
     *
     * @var array
     */
    protected static $alias = array(
        'Mysql' => 'mysql',
        'Sqlite' => 'Sqlite',
        'Postgresql' => 'pgsql',
    );

    #
    ##
    ###
    # BASICS #

    /**
     * @abstract
     * Abre ou retorna uma conexão conexão com um determinado banco dedados.
     * A conexão definida solicitada e armazenada na classe {Connetion}.
     *
     * @param string $connection Nome da conexão que será trabalhada.
     * @return void
     */
    public static function connection($connection = 'default') {
        $config = Connection::get($connection);

        # iniciando conexão, caso isto ainda não tenha sido feito.
        if (!array_key_exists('connection', $config)) {
            if (!$conn = new PDO(static::alias() . ':host=' . $config['host'] . ';dbname=' . $config['database'], $config['user'], $config['password']))
                throw new ConnectionFailed($connection);

            $conn->exec('SET CHARACTER SET utf-8;');
            Connection::$connections[$connection]['connection'] = $conn;
        }

        return Connection::$connections[$connection]['connection'];
    }

    /**
     * @abstract
     * Executa uma query SQL em uma determinada conexão.
     *
     * @param string $sql SQL que será executada.
     * @param string $connection Nome da conexão que será referenciada.
     * @param array $bind_values Valores vinculados ao $sql
     * @return bool||array
     */
    public static function query($sql, $connection = 'default', array $bind_values = null) {

        # obtemos o datasource
        # preparamos a query SQL e vinculamos os valores informados precavendo de SQL injections
        $datasource = Connection::datasource($connection);
        $result = $datasource::connection($connection)->prepare($sql);

        $result->execute($bind_values ?: Query::values());

        # armazenamos o statement para outras verificações posteriores a query SQL
        Connection::$connections[$connection]['statement'] = $result;

        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        return (is_array($result) && empty($result)) ? TRUE : $result;
    }

    #
    ##
    ###
    # SCHEMA #

    /**
     * @abstract
     * Obtém os bancos de dados uma determinada conexão.
     *
     * @param string $connection Nome da conexão que será referenciada.
     * @return array Bancos de dados: array('database01', 'database02')
     */
    abstract static function databases(&$connection = 'default');

    /**
     * @abstract
     * Obtem as tabelas de uma determinada conexão.
     *
     * @param string $connection Nome da conexão que será referenciada.
     * @return array Tabelas: array('tabela01', 'tabela02')
     */
    abstract static function tables($connection = 'default');

    /**
     * @abstract
     * Obtem as uma determinada colunas em uma tabela.
     *
     * @param string $table Nome da tabela que será referenciada.
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return array Colunas: array('coluna01', 'coluna02')
     */
    abstract static function columns($table, $connection = 'default');

    /**
     * @abstract
     * Obtem a tipagem de uma determinada coluna em uma tabela.
     *
     * @param string $table Nome da tabela que será referenciada.
     * @param string $column Nome da coluna que será referenciada.
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return string Tipagem
     */
    abstract static function columnType($table, $column, $connection = 'default');

    /**
     * @abstract
     * Obtem a descrição de uma determinada coluna em uma tabela. Deve-se
     * descrever se pode ser nula, se é primária, etc...
     *
     * @param string $table Nome da tabela que será referenciada.
     * @param string $column Nome da coluna que será referenciada.
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return array
     */
    abstract static function columnDescription($table, $column, $connection = 'default');

    #
    ##
    ###
    # CRUD #

    /**
     * Seleciona um ou mais registros do banco de dados.
     *
     * @param array $options Documentação na classe Query::select()
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return array
     */
    public static function select($options, $connection = 'default') {
//        dp(Query::select($options, 'sqlite'));
//        return static::query(Query::select($options, static::alias()), $connection);
        return static::query(Query::select($options, 'sqlite'), $connection);
    }

    /**
     * @abstract
     * Insere um registro em uma determinada tabela.
     *
     * @param string $table Tabela que será referenciada.
     * @param string $records Dados que serão inseridos: [cols: vals] || [[cols: vals], [cols: vals]].
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return boolean
     */
    public static function insert($table, $records, $connection = 'default') {
        $sql = Query::insert($table, $records, static::alias());

        # efetuamos o log auditor de conexões (SQL)
        log_write('auditor' . I . "{$connection}_" . static::nameAlias(), json_encode(array('sql' => $sql, 'bind_values' => Query::values(FALSE))));

        return static::query($sql, $connection);
    }

    /**
     * @abstract
     * Atualiza um conjunto de registros em uma determinada tabela.
     *
     * @param string $table Tabela que será referenciada.
     * @param string $datas Dados que serão inseridos: array('column01' => value01').
     * $param array $where Condições de atualizaçõ: array("id = 'i1sd'", array('name' => 'names'))
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return boolean
     */
    public static function update($table, $record, $where = null, $connection = 'default') {
        $sql = Query::update($table, $record, $where, static::alias());

        # efetuamos o log auditor de conexões (SQL)
        log_write('auditor' . I . "{$connection}_" . static::nameAlias(), json_encode(array('sql' => $sql, 'bind_values' => Query::values(FALSE))));

        return static::query($sql, $connection);
    }

    /**
     * @abstract
     * Deleta um conjunto de registros de uma determinada tabela.
     *
     * @param string $table Tabela que será referenciada.
     * $param array $where Condições de deleção: array("id = 'i1sd'", array('name' => 'names'))
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return boolean
     */
    public static function delete($table, $where = array(), $connection = 'default') {
        $sql = Query::delete($table, $where, static::alias());

        # efetuamos o log auditor de conexões (SQL)
        log_write('auditor' . I . "{$connection}_" . static::nameAlias(), json_encode(array('sql' => $sql, 'bind_values' => Query::values(FALSE))));

        return static::query($sql, $connection);
    }

    #
    ##
    ###
    # UTILITY #

    /**
     * Obtém o último erro ocorrido em uma determinada conexão.
     *
     * @param string $connection
     */
    public static function lastError($connection = 'default') {
        return @Connection::$connections[$connection]['statement']->errorInfo() ?: null;
    }

    /**
     * @abstract
     * Obtém o primeiro registro de uma busca em uma determinada tabela.
     *
     * @param string $table Tabela que será referenciada.
     * @param array $options Opções qe serão aplicadas nas intruções HTML
     *  array(
     *      'order' => 'id ASC',
     *      'fields' => 'id, name',
     *      'where' => array("id = 'i1sd'", array('name' => 'names')),
     *  );
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return array
     */
    public static function first($table, array $options = array(), $connection = 'default') {
        $options['limit'] = 1;
        $options['table'] = $table;

        if (!$table = static::select($options, $connection))
            return array();

        return $table[0];
    }

    /**
     * @abstract
     * Obtém um novo ID único baseado nos registros de uma determinada tabela.
     *
     * @param string $table Tabela que será referenciada.
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return string
     */
    public static function newId($table, $connection = 'default') {
        $id_duplicate = true;

        while ($id_duplicate == true) {
            $id = sha1(\Security::random() . date('Y-m-d H:i:s'));

            $id_duplicate = static::first($table, array(
                        'fields' => 'id',
                        'where' => 'id = \'' . $id . '\''
                            ), $connection);

            $id_duplicate = !empty($id_duplicate);
        }

        return $id;
    }

    /**
     * @abstract
     * Obtém um conjunto de registros baseado no valor de uma coluna.
     *
     * @param string $table Tabela que será referenciada.
     * @param array $options Opções qe serão aplicadas nas intruções HTML
     *  array(
     *      'order' => 'id ASC',
     *      'fields' => 'id, name',
     *      'where' => array("id = 'i1sd'", array('name' => 'names')),
     *      'limit' => 1
     *  );
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return array
     */
    public static function byColumn($table, $column, $value, $options = array(), $connection = 'default') {
        $options['table'] = $table;
        $options['where'] = array($column => $value);
        return static::select($options, $connection);
    }

    /**
     * @abstract
     * Obtém um registro baseado no valor da coluna ID.
     *
     * @param string $table Tabela que será referenciada.
     * @param array $options Opções qe serão aplicadas nas intruções HTML
     *  array(
     *      'order' => 'id ASC',
     *      'fields' => 'id, name',
     *      'where' => array("id = 'i1sd'", array('name' => 'names')),
     *      'limit' => 1
     *  );
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return array
     */
    public static function byId($table, $value, $options = array(), $connection = 'default') {
        return static::byColumn($table, 'id', $value, $options, $connection);
    }

    /**
     * @abstract
     * Efetua a contagem de um conjunto de registros.
     *
     * @param string $table Tabela que será referenciada.
     * $param array $where Condições de countagem: array("id = 'i1sd'", array('name' => 'names'))
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return int
     */
    public static function count($table, $where = '', $connection = 'default') {
        if (!empty($where))
            $options['where'] = $where;

        $options['table'] = $table;
        $options['fields'] = 'count(*) AS c';
        $table = static::select($options, $connection);

        return isset($table[0]) ? $table[0]['c'] : 0;
    }

    /**
     * @abstract
     * Verifica se existe registros baseados em determinadas condições.
     *
     * @param string $table Tabela que será referenciada.
     * $param array $where Condições de verificação: array("id = 'i1sd'", array('name' => 'names'))
     * @param string $connection Nome da conexão que será referenciada.
     *
     * @return boolean
     */
    public static function exists($table, $where = '', $connection = 'default') {
        return static::count($table, $where, $connection) > 0;
    }

    /**
     * Inicia uma transação.
     */
    public static function begin($connection = 'default') {
        return static::query('BEGIN TRANSACTION;', $connection);
    }

    /**
     * Comita uma transação.
     */
    public static function commit($connection = 'default') {
        return static::query('COMMIT;', $connection);
    }

    #
    ##
    ###
    # PRIVATE #

    /**
     * Obtém o nome do datasource no escopo interno do gerador de queries.
     *
     * @return string
     */
    protected static function alias() {
        return @static::$alias[static::name()] ?: 'mysql';
    }

}
