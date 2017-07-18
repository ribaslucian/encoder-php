-- Tabela genérica para usuário Liv
DROP TABLE IF EXISTS merchant_users CASCADE;
CREATE TABLE merchant_users (
    id SERIAL PRIMARY KEY,
    id_ns VARCHAR(64) NOT NULL UNIQUE,

    name VARCHAR(92) NOT NULL,
    email VARCHAR(92) NOT NULL,
    password VARCHAR(64) NOT NULL,

    hierarchy VARCHAR(32) DEFAULT 'merchant',
    active BOOLEAN DEFAULT TRUE,

    hash_confirm_account VARCHAR(64),
    hash_password_renew VARCHAR(64),
    hash_unlock_account VARCHAR(64),

    login_count INTEGER DEFAULT 0,
    login_attempts DECIMAL(2) DEFAULT 0, 
    last_login TIMESTAMP,

    created TIMESTAMP DEFAULT now(),

    -- accredited_id, seller_id
    merchant_id INT,
    cnpj VARCHAR(18),

    -- mercado,cupom,cantina,ingresso,festa
    benefits_id VARCHAR(64) NOT NULL

    -- json com informações complementares como
    -- complements VARCHAR(1024)
);