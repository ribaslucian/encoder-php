DROP VIEW IF EXISTS view_accrediteds_benefits CASCADE;

CREATE VIEW view_accrediteds_benefits (
    benefit_id, accredited_id,
    benefit, accredited, cnpj
) AS (
    SELECT
	accreditedbenefits_id, accredited.id,
	benefit, accreditedassumedname, accreditedcnpj
    FROM accredited
    LEFT JOIN accredited_benefit ON (accrediteds_id = accredited.id)
    LEFT JOIN benefit ON (benefit.id = accreditedbenefits_id)
);