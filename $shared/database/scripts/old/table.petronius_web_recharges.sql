DROP TABLE IF EXISTS web_recharges CASCADE;
CREATE TABLE web_recharges (
    id VARCHAR(64) PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,

    issuer VARCHAR(24),
    issuer_id INTEGER,
    date_liberation TIMESTAMP,
    total NUMERIC(11, 2),

    default_value NUMERIC(11, 2),
    total_employees DECIMAL(6),
    employees_up TEXT,
    employees_down TEXT,
    employees_in TEXT,
    employees_null TEXT,

    approved BOOLEAN DEFAULT FALSE,
    released BOOLEAN DEFAULT FALSE,
    proof_of_payment_path VARCHAR(256) DEFAULT NULL,
    billet_path VARCHAR(256) DEFAULT NULL,
    reference_date VARCHAR(32),

    created_at TIMESTAMP DEFAULT NOW(),
    update_at TIMESTAMP DEFAULT NOW()
);

-- rechargedate: quando fez a recarga
-- balance... : 0