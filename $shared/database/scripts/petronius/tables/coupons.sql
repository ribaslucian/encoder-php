-- Vales impressos (unicentro, xavantes)
DROP TABLE IF EXISTS coupons CASCADE;
CREATE TABLE coupons (
    id SERIAL PRIMARY KEY,
    id_ns VARCHAR(64) NOT NULL UNIQUE,

    issuer_id INT NOT NULL,
   
    date_validate TIMESTAMP DEFAULT now(),
    date_emission TIMESTAMP DEFAULT now(),
    date_apresentation TIMESTAMP DEFAULT now(),
    canceled BOOLEAN DEFAULT FALSE,

    value NUMERIC(15,2) NOT NULL,

    created TIMESTAMP DEFAULT now()

    -- verificar na tabela de transações
    -- date_validation TIMESTAMP DEFAULT now(), -- data que o ticket foi validado
    -- seller_id TIMESTAMP DEFAULT now(), -- quem validou

    -- json com informações complementares
    -- complements VARCHAR(1024)
);