-- mes atual
SELECT COUNT(*) AS amount,  to_char(NOW(), 'Month') AS month,  DATE_TRUNC('MONTH', NOW()) AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW())

-- mes atual -1
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '1 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW())

-- mes atual -2
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '2 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '1 MONTH')

-- mes atual -3
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '3 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '2 MONTH')

-- mes atual -4
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '4 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '3 MONTH')

-- mes atual -5
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '5 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '4 MONTH')

-- mes atual -6
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '6 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '5 MONTH')

-- mes atual -7
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '7 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '6 MONTH')

-- mes atual -8
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '8 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '7 MONTH')

-- mes atual -9
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '9 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '8 MONTH')

-- mes atual -10
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '10 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '9 MONTH')

-- mes atual -11
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '11 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '10 MONTH')

-- mes atual -12
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '12 MONTH', 'Month') AS month,  DATE_TRUNC('MONTH', NOW() - INTERVAL '12 MONTH') AS date
FROM transactions WHERE transaction_date  >= DATE_TRUNC('MONTH', NOW() - INTERVAL '12 MONTH') AND  transaction_date  <= DATE_TRUNC('MONTH', NOW() - INTERVAL '11 MONTH')

ORDER BY date;
