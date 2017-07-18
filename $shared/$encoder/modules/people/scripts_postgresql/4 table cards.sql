DROP TABLE IF EXISTS cards;

CREATE TABLE cards (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP

    account_id BIGINT NOT NULL REFERENCES accounts(id),
);