<?php

/**
 * Gerador de scripts SQL genérico.
 * 
 * A classe é abstrata e estática pois em nenhum momento será necessária sua 
 * independente instanciação.
 * 
 * @author Lucian Rossoni Ribas <ribas.lucian@gmail.com>
 * @link <https://www.facebook.com/lucian.ribas> Facebook
 */
class Query extends Object {

    /**
     * Instancia do gerador de queries criados no momento.
     * 
     * @var Aura\SqlQuery\?
     */
    private static $query;

    /**
     * Método gerados da query completa de um insert.
     * 
     * @param array||string $options 
     *   string table_name 
     *   array(
     *     from: 
     *       string tables: 'table1, table2, tableN'
     *       array[
     *         table1, table2, tableN,
     *         select: 'SELECT * ... AS sub_select'
     *       ],
     *     fields:
     *       string fields: 'field1, field2, fieldN'
     *       array(field1, field2, fieldN)
     *     join: [
     *       'left/inner/natural/etc',
     *       'table AS t',
     *       'other.id = t.id'
     *     ]
     *     subJoin: [
     *       'left/inner/natural/etc',
     *       'SELECT ... AS sub_select_join',
     *       'table AS t',
     *       'other.id = t.id'
     *     ]
     *     where: 
     *       string conditions: conditions = 1 AND ... OR ...
     *       array(
     *         'conditions = 1 AND ... OR ...'
     *         array(condition = ?, value)
     *         or: 'foo < :foo'
     *       )
     *     having: 
     *       string conditions: condition1, condition2, conditionN
     *       array(
     *         condition1, condition2, conditionN
     *         array(condition = ?, value)
     *         or: 'foo < :foo'
     *       )
     *     group:
     *       string groups: 'group1, group2, groupN'
     *       array(group1, group2, groupN)
     *     order:
     *       string orders: 'order1', 'order2 desc', 'orderN'
     *       array(order1, order2 desc, orderN)
     *     limit: integer
     *     offset: integer
     *     union: true
     *     unionAll: true
     *     values: array(:values => values)
     *   )
     * 
     * @param string $datasource_alias
     */
    public static function select($options, $datasource_alias = 'sqlite') {

        # example
//        Query::select([
//            'fields' => 'f1, f2',
//            'table' => 'users',
//            'order' => 'o1, o2 desc',
//            'group' => 'g1, g2',
//            'limit' => 8,
//            'offset' => 13,
//            'unionAll' => true,
//            'where' => array(
//                'conditions = 1',
//                'conditions = 2',
//                'or' => 'conditions = 4',
//                array('id = ?', 3)
//            ),
//            'having' => array(
//                'conditions = :1',
//                'conditions = :2',
//                'or' => 'conditions = 4',
//                array('id = ?', 3)
//            ),
//            'join' => array('left', 'table AS t', 'foo.id = t.id'),
//            'subJoin' => array(
//                'left',
//                'SELEC * FROM u',
//                'table AS t',
//                'foo.id = t.id'
//            ),
//            'values' => array(
//                '1' => 11,
//                '2' => 11,
//            )
//        ]);
        # iniciamos o recurso de criação de queries SQL
        $resource = new \Aura\SqlQuery\QueryFactory($datasource_alias);
        static::$query = $select = $resource->newSelect();

        # se $options é string então é representa o * FROM do select
        if (is_string($options))
            $select->from($options)->cols(array('*'));
        else {

            # definimos o FIELDS do select
            if (isset($options['fields']))
                static::setFields($options['fields'], $select);
            else
                $select->cols(array('*'));

            # definimos o FROM do select
            if (isset($options['table']))
                static::setFrom($options['table'], $select);

            # definimos o ORDER BY do select
            if (isset($options['order']))
                static::setOrder($options['order'], $select);

            # definimos o GROUP BY do select
            if (isset($options['group']))
                static::setGroup($options['group'], $select);

            # definimos o LIMIT do select
            if (isset($options['limit']))
                $select->limit($options['limit']);

            # definimos o OFFSET do select
            if (isset($options['offset']))
                $select->offset($options['offset']);

            # definimos o UNION do select
            if (isset($options['union']))
                $select->union();

            # definimos o UNION ALL do select
            if (isset($options['all']))
                $select->unionAll();

            # definimos o UNION ALL do select
            if (isset($options['forUpdate']))
                $select->forUpdate();

            # definimos o WHERE do select
            if (isset($options['where']))
                static::setWhere($options['where'], $select);

            # definimos o HAVING do select
            if (isset($options['having']))
                static::setHaving($options['having'], $select);

            # definimos os valores do select
            if (isset($options['values']))
                $select->bindValues($options['values']);

            # definimos o JOIN do select
            if (isset($options['join']))
                $select->join($options['join'][0], $options['join'][1], $options['join'][2]);

            # definimos o JOIN do select
            if (isset($options['subJoin']))
                $select->joinSubSelect($options['subJoin'][0], $options['subJoin'][1], $options['subJoin'][2], $options['subJoin'][3]);
        }

        return $select->getStatement();
    }

    /**
     * Obtém a query SQL para inserir registros no banco de dados.
     * 
     * @param string $table Tabela onde será inserido o(s) registro(s)
     * @param array $records[cols: values] || [[cols: values], [cols: values]]
     * @param string $datasource_alias
     */
    public static function insert($table, $records, $datasource_alias = 'sqlite') {
        # iniciamos o construtor de query para o $databasource
        $query = new Aura\SqlQuery\QueryFactory($datasource_alias);
        static::$query = $insert = $query->newInsert()->into($table);
        
        # verificando se é a inserção de 1 ou mais registro, adaptamos para o each
        if (Vetor::countBranches($records) <= 1)
            $records = array($records);

        foreach ($records as $record) {
            $insert->addRow()->cols($record);
        }

        return $insert->getStatement();
    }

    /**
     * Obtém a query SQL para atualizar registros no banco de dados.
     * 
     * @param string $table
     * @param array $record
     * @param array $conditions especificação dos registros que serão atualizados
     * @param string $datasource_alias
     * @return type
     */
    public static function update($table, array $record, $where = null, $datasource_alias = 'sqlite') {
        # iniciamos o recurso de criação de queries SQL
        $resource = new \Aura\SqlQuery\QueryFactory($datasource_alias);
        static::$query = $update = $resource->newUpdate();

        # registro que será atualizado não deve ser vazio
        if (empty($record))
            return FALSE;
        
        $update->table($table);

        # percorremos as colunas do registro que será atualizado
        $cols = array();
        foreach ($record as $field => $value) {
            $update->col($field);
            $update->bindValue($field, $value);
        }

        # verificamos se foi informado alguma condição
        if (!empty($where))
            static::setWhere($where, $update);

        return $update->getStatement();
    }

    /**
     * Obtém a query SQL para deletar registros no banco de dados.
     * 
     * @param string $table
     * @param array $where especificação dos registros que serão atualizados
     *  :@value para vincular valores
     * @param string $datasource_alias
     * @return type
     */
    public static function delete($table, $where = null, $datasource_alias = 'sqlite') {
        # iniciamos o recurso de criação de queries SQL
        $resource = new \Aura\SqlQuery\QueryFactory($datasource_alias);
        static::$query = $delete = $resource->newDelete();

        $delete->from($table);

        # definimos os valores do select
        if (isset($where['@values'])) {
            $delete->bindValues($where['@values']);
            unset($where['@values']);
        }

        # verificamos se foi informado alguma condição
        if (!empty($where))
            static::setWhere($where, $delete);

        return $delete->getStatement();
    }

    #
    ##
    ###
    # UTILS #

    /**
     * Obtém os valores vinculados em um determinado recurso.
     * 
     * @return array[name: value]
     */
    public static function values($destroy = true) {
        if (!empty(static::$query)) {
            $values = static::$query->getBindValues();

            # obtemos os valores e zeramos a query
            if ($destroy)
                static::$query = null;

            return $values;
        }

        return null;
    }

    #
    ##
    ###
    # PRIVATE #

    /**
     * Defines os campos da query.
     * 
     * @param string||array $from
     */
    private static function setFields($fields, $resource) {
        if (is_string($fields)) {
            $fields = str_to_array($fields);

            if (is_string($fields))
                $fields = array($fields);

            return $resource->cols($fields);
        } else {

            # percorremos os campos a serem inseridos
            foreach ($fields as $key => $field) {

                # verificamos se é um sub query from
                if ($key === 'sub') {
                    # recurso indisponível
                    # $resource->fromSubSelect(explode(' as ', strtolower($field)));
                } else {
                    $field = str_to_array($field);

                    if (is_string($field))
                        $field = array($field);

                    $resource->cols($field);
                }
            }
        }
    }

    /**
     * Defines o FROM da query.
     * 
     * @param string||array $from
     */
    private static function setFrom($from, $resource) {
        if (is_string($from)) {
            $from = str_to_array($from);

            if (is_string($from))
                $from = array($from);
        }

        foreach ($from as $table)
            $resource->from($table);
    }

    /**
     * Defines o ORDER da query.
     * 
     * @param string||array $from
     */
    private static function setOrder($orders, $resource) {
        if (is_string($orders)) {
            $orders = str_to_array($orders);

            if (is_string($orders))
                $orders = array($orders);
        }

        $resource->orderBy($orders);
    }

    /**
     * Defines o GROU BY da query.
     * 
     * @param string||array $from
     */
    private static function setGroup($groups, $resource) {
        if (is_string($groups)) {
            $groups = str_to_array($groups);

            if (is_string($groups))
                $groups = array($groups);
        }

        $resource->groupBy($groups);
    }

    /**
     * Defines o WHERE da query.
     * 
     * @param string||array $from
     */
    private static function setWhere($where, $resource) {
        if (is_string($where))
            return $resource->where($where);

        if (is_array($where)) {

            # percorremos, analizamos e definimos as condições
            foreach ($where as $key => $conditions) {

                if ($key == 'or') {
                    $resource->orWhere($conditions[0]);
                } else if (is_string($key) && !is_int($key)) {

                    # inserimos o comparador caso não tenha sido informado
                    if ((strpos($key, '<') === false) && (strpos($key, '>') === false) && strpos($key, '=') === false)
                        $key .= ' =';

                    $resource->where("$key ?", $conditions);
                } else {
                    # se for um array os valores do where serão escapados
                    if (is_array($conditions))
                        $resource->where($conditions[0], $conditions[1]);
                    else
                        $resource->where($conditions);
                }
            }
        }
    }

    /**
     * Define o HAVING da query.
     * 
     * @param string||array $from
     */
    private static function setHaving($having, $resource) {
        if (is_string($having))
            return $resource->where($having);

        if (is_array($having)) {

            # percorremos, analizamos e definimos as condições
            foreach ($having as $key => $conditions) {

                if ($key == 'or') {
                    $resource->orHaving($conditions);
                } else {
                    # se for um array os valores do where serão escapados
                    if (is_array($conditions))
                        $resource->having($conditions[0], $conditions[1]);
                    else
                        $resource->having($conditions);
                }
            }
        }
    }

}
