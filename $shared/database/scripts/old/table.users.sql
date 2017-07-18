DROP TABLE IF EXISTS contractor_users CASCADE;
CREATE TABLE contractor_users (
    id VARCHAR(50) PRIMARY KEY,

    email VARCHAR(92) UNIQUE,
    password VARCHAR(64),
    hierarchy VARCHAR(32),
    active BOOLEAN DEFAULT FALSE,
    issuer_id BIGINT,

    name VARCHAR(92),
    documentation VARCHAR(24),
    cep VARCHAR(9),
    address VARCHAR(256),
    phone VARCHAR(16),

    password_forgot_hash VARCHAR(124) UNIQUE,
    password_forgot_at TIMESTAMP,

    confirm_account_hash VARCHAR(124) UNIQUE,
    confirm_account_at TIMESTAMP,

    unlock_account_hash VARCHAR(124) UNIQUE,
    unlock_account_at TIMESTAMP,

    login_count INTEGER,
    login_attempts DECIMAL(1), 
    last_login TIMESTAMP,

    created_at TIMESTAMP DEFAULT NOW(),
    update_at TIMESTAMP DEFAULT NOW()
);

-- alter table contractor_users add column address varchar(256);
-- update contractor_users set address = number;
-- alter table contractor_users drop column number;