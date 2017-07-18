-- Nova tabela de transações do Magno focando a genericidade 
-- transacional, centralizando as transações de todos os benefícios.
--DROP TABLE IF EXISTS transactions CASCADE;
CREATE TABLE transactions (

    -- campos básicos de uma transação
    id SERIAL PRIMARY KEY,
    id_ns VARCHAR(64) NOT NULL UNIQUE,
    accredited_id INT NOT NULL,
    benefit_id SMALLINT NOT NULL,
    invoice_id INT,
    date TIMESTAMP DEFAULT now(),
    canceled BOOLEAN DEFAULT FALSE,
    value NUMERIC(15,2) NOT NULL,
    created TIMESTAMP DEFAULT now(),

    -- campos complementares
    issuer_id INT,
    coupon_id INT

    -- json com informações complementares como:
    -- {
    --     issuer_id: INT,
    --     ticket_id: BIGINT,
    --     coupon_id: BIGINT,
    --     transaction_id: BIGINT,
    --     coupon_code: STRING(62),
    --     balance: NUMERIC(15,2),
    --     method: STRING(64) ['ingresso', 'vale', 'cartão', 'dinheiro'],
    --     type_payment: STRING(64) ['credito', 'debito'],
    --     * credited_id: INT,
    --     * debitant_id: INT,
    --     balance_before_credited: NUMERIC(15,2),
    --     balance_before_debitant: NUMERIC(15,2),
    --     ...
    -- }
    -- complements VARCHAR(1024)
);