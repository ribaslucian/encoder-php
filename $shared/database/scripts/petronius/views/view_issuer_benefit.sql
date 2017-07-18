DROP VIEW IF EXISTS view_issuer_benefit CASCADE;

CREATE VIEW view_issuer_benefit (
    benefit_id, issuer_id,
    benefit, issuer, cnpj
) AS (
    SELECT
	issuerbenefits_id, issuer.id,
	benefit, issuerassumedname, issuercnpj	
    FROM issuer
    LEFT JOIN issuer_benefit ON (issuers_id = issuer.id)
    LEFT JOIN benefit ON (benefit.id = issuerbenefits_id)
);