-- obtendo todos os titulares de Palmeira
SELECT 
	issuercardholders_id AS holder_id,
	cardholdername AS holder_name,
	cardholdercpf AS holder_cpf
FROM issuer_cardholder

INNER JOIN cardholder ON (cardholder.id = issuercardholders_id)

WHERE
cardholdername NOT LIKE '%*%' -- eleminando titulares com nome invalido
AND cardholdername NOT LIKE '%\%%' 
AND cardholdername NOT LIKE '%TESTE%' 
AND issuers_id = 19 -- contratante respectivo

ORDER BY holder_name;