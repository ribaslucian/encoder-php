DROP VIEW IF EXISTS view_holder_balance CASCADE;

CREATE VIEW view_holder_balance (
    id, issuer_id, 
    name, cpf, 
    job_date_of_fire, fire_order_by,
    issuer, issuer_cnpj,
    last_recharge, last_recharge_date,
    last_transaction_balance, last_transaction_date
) AS (

    SELECT 
	cardholder.id AS id, 
	issuer.id AS issuer_id,
	cardholdername, cardholdercpf,
	job_date_of_fire, fire_order_by,
	issuerassumedname,
	issuercnpj,
	(SELECT rechargevalue AS last_recharge FROM recharge2 WHERE cardholder_id = cardholder.id ORDER BY rechargedate DESC LIMIT 1),
	(SELECT rechargedate AS last_recharge_date FROM recharge2 WHERE cardholder_id = cardholder.id ORDER BY rechargedate DESC LIMIT 1),
	(SELECT cardholderbalance AS last_transaction_balance FROM dblink('magno', 'SELECT cardholderbalance FROM debittransaction WHERE idcardholder = ' || cardholder.id || ' ORDER BY transactiondate DESC LIMIT 1;') AS t1(cardholderbalance double precision)),
	(SELECT transactiondate AS last_transaction_date FROM dblink('magno', 'SELECT transactiondate FROM debittransaction WHERE idcardholder = ' || cardholder.id || ' ORDER BY transactiondate DESC LIMIT 1;') AS t1(transactiondate timestamp))

    FROM cardholder 

    LEFT JOIN issuer_cardholder ON (issuercardholders_id = cardholder.id)
    LEFT JOIN issuer ON (issuers_id = issuer.id)
    ORDER BY cardholder.id
);