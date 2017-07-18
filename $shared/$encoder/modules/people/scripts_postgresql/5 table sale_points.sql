DROP TABLE IF EXISTS transactions;

CREATE TABLE transactions (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP

    account_id BIGINT NOT NULL REFERENCES accounts(id),
);