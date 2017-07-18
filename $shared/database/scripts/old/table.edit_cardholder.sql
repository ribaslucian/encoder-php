-- data de demissão (desligamento).
ALTER TABLE cardholder ADD COLUMN job_date_of_fire TIMESTAMP;

-- email do usuário que efetuou a operação de desligamento do funcionário.
ALTER TABLE cardholder ADD COLUMN fire_order_by VARCHAR(92);