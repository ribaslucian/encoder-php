-- de transações
DROP VIEW IF EXISTS transactions_view CASCADE;
CREATE VIEW transactions_view (
    id, seller_card_count, device_id, seller_id, holder_id, card_id, issuer_id, benefit_id, invoice_id,
    seller_name, holder_name, issuer_name, benefit_name, invoice_code,
    value, balance, canceled, date, created
) AS (
    SELECT
        transactions.id, transactions.seller_card_count, device_id, transactions.seller_id, holder_id, transactions.card_id, issuer_id, benefit_id, invoice_id,
        sellers.name, holders.name, issuers.name, benefits.name, invoices.code,
        transactions.value, transactions.balance, canceled, transaction_date, transactions.created
    FROM transactions
    LEFT JOIN holders ON (holder_id = holders.id)
    LEFT JOIN sellers ON (seller_id = sellers.id)
    LEFT JOIN issuers ON (issuer_id = issuers.id)
    LEFT JOIN benefits ON (benefit_id = benefits.id)
    LEFT JOIN invoices ON (invoice_id = invoices.id)
);
SELECT * FROM transactions_view LIMIT 10;

-- de titulares
DROP VIEW IF EXISTS holders_view CASCADE;
CREATE VIEW holders_view (
    id, issuer_id, name, issuer_name, cpf, email, phone
) AS (
    SELECT
	holders.id, issuers.id,
	holders.name, issuers.name,
	holders.cpf, holders.email, holders.phone
    FROM holders
    LEFT JOIN issuers ON (issuer_id = issuers.id)
);
SELECT * FROM holders_view LIMIT 10;


-- de cartões
DROP VIEW IF EXISTS cards_view CASCADE;
CREATE VIEW cards_view (
    id, holder_id, code, balance, holder_name,
    blocked, type, expires_in, app_version, created
) AS (
    SELECT
        cards.id, holder_id, code, balance, name,
        blocked, type, expires_in, app_version, cards.created
    FROM cards
    LEFT JOIN holders ON (holder_id = holders.id)
);
SELECT * FROM cards_view LIMIT 10;


-- de benefícios atribuídos
DROP VIEW IF EXISTS benefit_assigments_view CASCADE;
CREATE VIEW benefit_assigments_view (
    id, benefit_id, entity_id, benefit_name, entity, created
) AS (
	SELECT benefit_assigments.id, benefit_id, entity_id, name, entity, benefit_assigments.created
	FROM benefit_assigments
	LEFT JOIN benefits ON (benefit_id = benefits.id)
);
SELECT * FROM benefit_assigments_view LIMIT 10;


-- Faturas
DROP VIEW IF EXISTS invoices_view CASCADE;
CREATE VIEW invoices_view (
    id, seller_id, code, seller_name, total_transactions, movement, first_transaction_on_card, last_transaction_on_card,
    monthly_pay, administration_rate_persent, administration_rate_reals, bank_pay, gross_pay, net_pay,
    issqn_persent, issqn_reals, date_end, proof_of_payment_path, settled_in, created
) AS (
    SELECT
        invoices.id, seller_id, code, name, total_transactions, movement, first_transaction_on_card, last_transaction_on_card,
        invoices.monthly_pay, invoices.administration_rate_persent, administration_rate_reals, invoices.bank_pay, gross_pay, net_pay,
        invoices.issqn_persent, issqn_reals, date_end, proof_of_payment_path, settled_in, invoices.created
    FROM invoices
    LEFT JOIN sellers ON (seller_id = sellers.id)
);
SELECT * FROM invoices_view LIMIT 10;
