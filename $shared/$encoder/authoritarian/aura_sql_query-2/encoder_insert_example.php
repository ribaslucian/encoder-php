<?php

$query = new Aura\SqlQuery\QueryFactory('pgsql');

$select = $query->newInsert();

$select
        ->cols(array(
            'id',
            'name AS namecol',
            'col_name' => 'col_alias',
            'COUNT(foo) AS foo_count'
        ))
        ->from('yogurte AS y')
        ->join(
                'LEFT', 'doom AS d', 'foo.id = d.foo_id'
        )
        ->joinSubSelect(
                'INNER', 'SELECT ...', 'subjoin', 'sub.id = foo.id'
        )
        ->where('zim = ?', 'zim_val')
        ->orWhere('baz < :baz')
        ->groupBy(array('dib', 'test'))
        ->having('foo = :foo')
        ->having('bar > ?', 'bar_val')
        ->orHaving('baz < :baz')
        ->orderBy(array('baz'))
        ->limit(10)
        ->offset(40)
        ->forUpdate()
        ->bindValue('foo', 'foo_val')
        ->bindValues(array(
            'bar' => 'bar_val',
            'baz' => 'baz_val',
        ));


echo $select->getStatement();
pr($select->getBindValues());
