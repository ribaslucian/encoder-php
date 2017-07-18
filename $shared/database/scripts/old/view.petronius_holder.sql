SELECT 
	issuer.id AS issuer_id, cardholder.id AS holder_id,
	issuercorporatename AS issuer_corporate_name, issuerassumedname AS issuer_assumed_name, issuercnpj AS issuer_cnpj, 
	cardholdername AS cardholder_name, cardholdercpf AS cardholder_cpf
FROM issuer_cardholder
INNER JOIN issuer ON (issuer.id = issuers_id)
INNER JOIN cardholder ON (cardholder.id = issuercardholders_id)
LIMIT 1;