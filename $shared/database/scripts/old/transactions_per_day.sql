-- hoje
SELECT COUNT(*) AS amount,  to_char(NOW(), 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW()) AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW())

-- hoje -1
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '1 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '1 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '1 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW())

-- hoje -2
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '2 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '2 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '2 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '1 DAY')

-- hoje -3
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '3 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '3 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '3 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '2 DAY')

-- hoje -4
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '4 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '4 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '4 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '3 DAY')

-- hoje -5
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '5 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '5 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '5 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '4 DAY')

-- hoje -6
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '6 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '6 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '6 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '5 DAY')

-- hoje -7
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '7 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '7 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '7 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '6 DAY')

-- hoje -8
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '8 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '8 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '8 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '7 DAY')

-- hoje -9
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '9 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '9 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '9 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '8 DAY')

-- hoje -10
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '10 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '10 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '10 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '9 DAY')

-- hoje -11
UNION SELECT COUNT(*) AS amount,  to_char(NOW() - INTERVAL '11 DAY', 'DD/Month') AS day,  DATE_TRUNC('DAY', NOW() - INTERVAL '11 DAY') AS date
FROM transactions WHERE transaction_date >= DATE_TRUNC('DAY', NOW() - INTERVAL '11 DAY') AND  transaction_date <= DATE_TRUNC('DAY', NOW() - INTERVAL '10 DAY')

ORDER BY date;
