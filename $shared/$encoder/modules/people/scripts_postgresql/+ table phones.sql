DROP TABLE IF EXISTS phones CASCADE;

CREATE TABLE phones (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR(64) UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP,

    person_id BIGINT REFERENCES people(id),
    corporation_id BIGINT REFERENCES corporations(id),

    phone VARCHAR(24)
);

-- regra NOT NULL composta para person_id e corporation_id
ALTER TABLE phones DROP CONSTRAINT IF EXISTS phones_only_one_person;
ALTER TABLE phones ADD CONSTRAINT phones_only_one_person CHECK (person_id IS NULL != corporation_id IS NULL);