-- obtendo todos os titulares de Palmeira
SELECT 
	issuercardholders_id AS holder_id,
	cardholdername AS holder_name,
	cardholdercpf AS holder_cpf,
	card.id AS card_id,
	card.blocked AS card_blocked,
	(SELECT count(*) AS cards_count FROM card WHERE cardholder_id = issuercardholders_id)
FROM issuer_cardholder

INNER JOIN cardholder ON (cardholder.id = issuercardholders_id)
INNER JOIN card ON (cardholder_id = issuercardholders_id)

WHERE
-- eleminando titulares com nome invalido
cardholdername NOT LIKE '%*%' AND cardholdername NOT LIKE '%\%%' AND

-- condicao para contratantes de palmeira
issuers_id IN (SELECT id FROM issuer WHERE issuerassumedname ~* 'palmeira')
ORDER BY cards_count DESC;
