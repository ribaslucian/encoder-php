<?php

/**
 * @config Connection
 */
connections(array(
    
    'default' => array(
        'source' => 'Sqlite',
        'path' => DATA . 'database' . I,
        'database' => 'sqlite'
    )

    # configurações padrões para outros bancos de dados
    # 'default' => array(
    #    'source' => 'Postgresql',
    #    'host' => 'localhost',
    #    'port' => 5432,
    #    'user' => 'postgres',
    #    'password' => 'postgres',
    #    'database' => 'postgres',
    # )
    # configuração específica para o SQLite
    # 'default' => array(
    #     'source' => 'Sqlite',
    #     'path' => DATA . 'database' . I,
    #     'database' => 'sqlite'
    # )
    # 'mysql' => array(
    #    'source' => 'Mysql',
    #    'database' => 'guinea',
    #    'user' => 'root',
    #    'password' => ''
    # )
));
