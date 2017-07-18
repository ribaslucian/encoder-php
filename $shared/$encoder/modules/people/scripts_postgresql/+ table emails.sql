DROP TABLE IF EXISTS emails CASCADE;

CREATE TABLE emails (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR(64) UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP,

    person_id BIGINT REFERENCES people(id),
    corporation_id BIGINT REFERENCES corporations(id),

    emails VARCHAR(64) NOT NULL
);

-- regra NOT NULL composta para person_id e corporation_id
ALTER TABLE emails DROP CONSTRAINT IF EXISTS emails_only_one_person;
ALTER TABLE emails ADD CONSTRAINT emails_only_one_person CHECK (person_id IS NULL != corporation_id IS NULL);