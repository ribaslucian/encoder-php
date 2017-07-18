DROP TABLE IF EXISTS address CASCADE;

CREATE TABLE address (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR(64) UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP,

    person_id BIGINT REFERENCES people(id),
    corporation_id BIGINT REFERENCES corporations(id),

    country VARCHAR(64),
    city DECIMAL(64),
    street DECIMAL(124),
    zipcode DECIMAL(12) NOT NULL,
    neighborhood DECIMAL(64),
    number DECIMAL(8)
);

-- regra NOT NULL composta para person_id e corporation_id
ALTER TABLE address DROP CONSTRAINT IF EXISTS address_only_one_person;
ALTER TABLE address ADD CONSTRAINT address_only_one_person CHECK (person_id IS NULL != corporation_id IS NULL);