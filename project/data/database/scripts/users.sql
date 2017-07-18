-- DROP TABLE users;

CREATE TABLE users (
    -- campos padrões
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated TIMESTAMP,

    name VARCHAR(92) NOT NULL UNIQUE DEFAULT '{username}',
    email VARCHAR(92) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    hierarchy VARCHAR(32) DEFAULT 'admin',

    active BOOLEAN DEFAULT TRUE,

    hash_confirm_account VARCHAR(64),
    hash_password_renew VARCHAR(64),
    hash_unlock_account VARCHAR(64),

    login_count INTEGER DEFAULT 0,
    login_attempts DECIMAL(2) DEFAULT 0, 
    last_login TIMESTAMP
);