WITH LOGICAL_recharges AS (

    SELECT 
        card_id,
        cardholder_id AS holder_id,
        issuer_id,

        issuerassumedname::text AS contractor,
        issuercnpj::text AS cnpj,

        cardholdername::text AS holder,
        cardholdercpf::text AS cpf,

        CASE WHEN didrecharge = TRUE THEN 'Sim' ELSE 'Não' END as did,
        rechargecode AS code,
        -- rechargevalue::float8::numeric::money::text AS "Valor",
        rechargevalue::float8::numeric AS value,
        balancebeforerecharge AS balance_before,

        rechargedate AS recharge_date,
        TO_CHAR(recharge2.registrationdate, 'DD/MM/YYYY HH:MI') AS registred,
        TO_CHAR(validfrom, 'DD/MM/YYYY HH:MI:SS') AS valid_from

    FROM recharge2

    LEFT JOIN issuer ON (issuer.id = issuer_id)
    LEFT JOIN cardholder ON (cardholder.id = cardholder_id)

    -- condicoes
    WHERE

        -- por empresa
        (issuercnpj = '03.222.465/0002-66' OR
        issuercnpj = '05.881.094/0001-79' OR
        issuercnpj = '19.072.739/0001-37' OR
        issuercnpj = '12.278.190/0001-92' OR
        issuercnpj = '03.222.465/0007-70' OR
        issuercnpj = '03.222.465/0004-28' OR
        issuercnpj = '03.222.465/0005-09' OR
        issuercnpj = '03.222.465/0001-85' OR
        issuercnpj = '14.867.538/0001-02')
        -- pedreira, dalba antiga
        -- OR issuercnpj = '77.001.105/0003-51')
        
        -- por dia
        AND recharge2.registrationdate >= '2017-03-19'
        -- recharge2.registrationdate <= '2017-03-19'

    ORDER BY issuerassumedname, cardholdername

    -- LIMIT 100
)

SELECT 
    'Total de Recargas' AS "Contratante",
    COUNT(*)::text as "CNPJ",
    NULL AS "Titular",
    NULL AS "CPF",
    NULL AS "Valor", 
    NULL AS "Obtida", 
    NULL AS "Valida Após"
FROM LOGICAL_recharges

UNION ALL (SELECT 
    'Total da Recarga' AS "null",
    substring(SUM(value)::money::text from 2), -- SUM(value)::money::text AS "null",
    NULL, NULL, NULL, NULL, NULL
FROM LOGICAL_recharges)

UNION ALL SELECT 
    contractor, cnpj, holder, cpf,
    -- value::money::text, -- substring(value::money::text from 3),
    replace(substring(value::money::text from 2), '.', ','),
    did, valid_from
FROM LOGICAL_recharges