DROP TABLE IF EXISTS sale_points;

CREATE TABLE sale_points (
    -- campos padrões
    id SERIAL PRIMARY KEY,
    ns_id VARCHAR UNIQUE,
    created TIMESTAMP DEFAULT NOW(),
    updated TIMESTAMP
);