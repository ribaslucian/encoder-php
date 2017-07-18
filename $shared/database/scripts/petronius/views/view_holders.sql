DROP VIEW IF EXISTS view_holders CASCADE;

CREATE VIEW view_holders (
    id, issuer_id, 
    name, cpf, 
    job_date_of_fire, fire_order_by,
    issuer, issuer_cnpj
) AS (

    SELECT 
        cardholder.id AS id, 
        issuer.id AS issuer_id,
        cardholdername, cardholdercpf,
        job_date_of_fire, fire_order_by,
        issuerassumedname,
        issuercnpj

    FROM cardholder 

    LEFT JOIN issuer_cardholder ON (issuercardholders_id = cardholder.id)
    LEFT JOIN issuer ON (issuers_id = issuer.id)
    ORDER BY cardholder.id
);