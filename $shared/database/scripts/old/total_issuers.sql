SELECT * FROM (
	(SELECT CAST(id AS VARCHAR), name, (SELECT SUM(value) FROM transactions_view WHERE issuer_id = issuers.id) AS total FROM issuers)
	UNION
	(SELECT 'total' AS id, CAST(COUNT(*) AS VARCHAR) AS name, (SELECT SUM(value) FROM transactions) FROM issuers)
) AS total_issuers WHERE total > 0 ORDER BY total DESC;