-- MÊS ATUAL
    -- emitidos
    SELECT count(*) AS amount, to_char(NOW(), 'Month/YYYY') AS month, DATE_TRUNC('MONTH', NOW()) AS date, 'emitidos' AS description
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW())

    -- ativos
    UNION SELECT count(*), to_char(NOW(), 'Month/YYYY'), DATE_TRUNC('MONTH', NOW()), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() + INTERVAL '1 MONTH') AND blocked = FALSE

-- MÊS ATUAL -1
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '1 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH') AND created <= DATE_TRUNC('MONTH', NOW())

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '1 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH') AND created <= DATE_TRUNC('MONTH', NOW()) AND blocked = FALSE

-- MÊS ATUAL -2
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '2 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '2 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH') AND blocked = FALSE

-- MÊS ATUAL -3
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '3 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '3 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH') AND blocked = FALSE

-- MÊS ATUAL -4
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '4 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '4 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH') AND blocked = FALSE

-- MÊS ATUAL -5
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '5 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '5 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH') AND blocked = FALSE

-- MÊS ATUAL -6
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '6 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '6 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH') AND blocked = FALSE

-- MÊS ATUAL -7
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '7 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '7 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH') AND blocked = FALSE

-- MÊS ATUAL -8
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '8 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '8 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH') AND blocked = FALSE

-- MÊS ATUAL -9
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '9 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '9 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH') AND blocked = FALSE

-- MÊS ATUAL -10
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '10 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '10 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH') AND blocked = FALSE

-- MÊS ATUAL -11
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '11 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '11 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH') AND blocked = FALSE

-- MÊS ATUAL -12
    -- emitidos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '12 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '12 MONTH'), 'emitidos'
    FROM cards WHERE created >= DATE_TRUNC('MONTH', NOW() - INTERVAL '12 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH')

    -- ativos
    UNION SELECT count(*), to_char(NOW() - INTERVAL '12 MONTH', 'Month/YYYY'), DATE_TRUNC('MONTH', NOW() - INTERVAL '12 MONTH'), 'ativos'
    FROM cards WHERE created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '12 MONTH') AND created <= DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH') AND blocked = FALSE

-- TOTAL
    -- emitidos
    UNION SELECT count(*), 'total', NULL, 'emitidos' FROM cards

    -- ativos
    UNION SELECT count(*), 'total', NULL, 'ativos' FROM cards WHERE blocked = FALSE

ORDER BY date, description;
