DROP TABLE IF EXISTS invoices CASCADE;
DROP TABLE IF EXISTS liv_users CASCADE;
DROP TABLE IF EXISTS activities CASCADE;
DROP TABLE IF EXISTS protocols CASCADE;
DROP TABLE IF EXISTS inventories CASCADE;
DROP TABLE IF EXISTS kits CASCADE;
DROP TABLE IF EXISTS kit_itens CASCADE;

-- Faturas
DROP TABLE IF EXISTS invoices CASCADE;
CREATE TABLE invoices (
    id serial PRIMARY KEY,

    code VARCHAR(24) UNIQUE,
    seller_id INTEGER,
    total_transactions INTEGER,
    movement NUMERIC(15,2),
    first_transaction_on_card INTEGER,
    last_transaction_on_card INTEGER,
    monthly_pay NUMERIC(5,2),
    administration_rate_persent NUMERIC(4,2),
    administration_rate_reals NUMERIC(10,2),
    bank_pay NUMERIC(10,2),
    gross_pay NUMERIC(15,2),
    net_pay NUMERIC(15,2),
    issqn_persent NUMERIC(4,2),
    issqn_reals NUMERIC(10,2),
    date_end TIMESTAMP DEFAULT NOW(),
    proof_of_payment_path VARCHAR(128),
    settled_in TIMESTAMP,

    created TIMESTAMP DEFAULT now()
);

/**
 * Usuário que acessam o sistema administrativo.
 */
-- DROP TABLE IF EXISTS users CASCADE;
-- CREATE TABLE users (
--   id smallserial PRIMARY KEY,
--   email character varying(64),
--   password character varying(50),
--   name character varying(92),
--   hierarchy character varying(24) NOT NULL,
--   enable boolean DEFAULT false,
--   birthday timestamp without time zone,
-- );

-- registro de atividades
DROP TABLE IF EXISTS activities CASCADE;
CREATE TABLE activities (
    id SERIAL PRIMARY KEY,

    -- Quem agendou a tarefa
    of_who SMALLINT,

    -- Quem deve desenvolver a tarefa
    for_who SMALLINT,

    type VARCHAR(64),
    description VARCHAR(1024),

    -- Prazo
    time_frame TIMESTAMP DEFAULT NULL,

    -- Quando foi concluída
    completed TIMESTAMP DEFAULT NULL,

    created TIMESTAMP DEFAULT now()
);

-- protocolos
DROP TABLE IF EXISTS protocols CASCADE;
CREATE TABLE protocols (
    id serial PRIMARY KEY ,
    code VARCHAR(12),
    person_type VARCHAR(16),
    costumer_name VARCHAR(92),
    costumer_documentation VARCHAR(24),
    costumer_id smallint,
    contractor_id smallint,
    contractor_name VARCHAR(92),
    reason VARCHAR(32),
    description VARCHAR(128),
    attendant smallint,
    responsible smallint,
    status VARCHAR(16),
    finished TIMESTAMP,
    created TIMESTAMP DEFAULT now()
);

-- inventário
DROP TABLE IF EXISTS inventories CASCADE;
CREATE TABLE inventories (
    id serial PRIMARY KEY,
    code integer,
    description VARCHAR(50),
    mark VARCHAR(50),
    model VARCHAR(50),
    mac VARCHAR(50),
    value money,
    location VARCHAR(100),
    aplication VARCHAR(50),
    situation VARCHAR(50),
    amount integer,
    last_scan TIMESTAMP,
    warranty TIMESTAMP,
    created TIMESTAMP DEFAULT now()
);

-- Usuários da cantina, senhas reais
DROP TABLE IF EXISTS canteen_users CASCADE;
CREATE TABLE canteen_users (
    id serial PRIMARY KEY,
    user_id integer,
    decrypted_password character varying(64),
    canteen character varying(92)
);

-- Kits
DROP TABLE IF EXISTS kits CASCADE;
CREATE TABLE kits (
    id              SERIAL PRIMARY KEY,

    name VARCHAR(20),
    status VARCHAR(16) DEFAULT 'Disponível',
    local VARCHAR(92),
    created TIMESTAMP DEFAULT NOW()
);

-- Itens do Kit
DROP TABLE IF EXISTS kit_itens CASCADE;
CREATE TABLE kit_itens (
    id              SERIAL PRIMARY KEY,

    kit_id int,
    item_id int,
    created TIMESTAMP DEFAULT NOW()
);