DROP VIEW IF EXISTS view_coupons CASCADE;

CREATE VIEW view_coupons (
    accredited_id, transaction_id, invoice_id, issuer_id, coupon_id, coupon_id_ns, 
    transaction_date, date_validate, date_emission, date_apresentation,
    created, value, issuer_name, issuer_cnpj
) AS (
    SELECT 
	accredited_id, transaction_id, invoice_id, issuer_id, coupons.id, id_ns,
        transaction_date, date_validate, date_emission, date_apresentation, 
        created, value, issuerassumedname, issuercnpj
    FROM
        dblink('magno', 'SELECT accredited_id, coupon_id, id, invoice_id, date FROM transactions WHERE coupon_id IS NOT NULL AND CANCELED IS FALSE;')
        AS t1(accredited_id INTEGER, coupon_id INTEGER, transaction_id INTEGER, invoice_id INTEGER, transaction_date TIMESTAMP)

        RIGHT JOIN coupons ON (coupons.id = coupon_id)
        LEFT JOIN issuer ON (issuer_id = issuer.id) 
);