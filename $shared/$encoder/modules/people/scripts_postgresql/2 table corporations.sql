DROP TABLE IF EXISTS corporations CASCADE;

CREATE TABLE corporations (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR(64) UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP,

    fantasy VARCHAR(124) NOT NULL,
    corporation VARCHAR(124),
    cnpj DECIMAL(16) NOT NULL
);