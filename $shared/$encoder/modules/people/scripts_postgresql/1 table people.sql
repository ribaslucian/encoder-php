DROP TABLE IF EXISTS people CASCADE;

CREATE TABLE people (
    -- campos padrões
    id BIGSERIAL PRIMARY KEY,
    ns_id VARCHAR(64) UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP,

    name VARCHAR(124) NOT NULL,
    cpf DECIMAL(11) NOT NULL
);