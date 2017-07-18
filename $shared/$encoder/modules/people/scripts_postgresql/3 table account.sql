DROP TABLE IF EXISTS account;

CREATE TABLE account (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP,

    person_id BIGINT NOT NULL REFERENCES people(id),
    corporation_id BIGINT NOT NULL REFERENCES corporations(id),

    balance FLOAT
);