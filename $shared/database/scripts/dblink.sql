-- ativar extensão DBLINK
CREATE EXTENSION dblink;

-- criar conexão
SELECT dblink_connect('magno', 'host=localhost dbname=magno user=postgres password=postgres port=5432');

-- verifica se uma conexão existe
CREATE OR REPLACE FUNCTION dblink_exists(text)
RETURNS bool AS $$
   SELECT COALESCE($1 = ANY (dblink_get_connections()), false)
$$ LANGUAGE sql;

-- Cria a conexão caso não exista: Estrutura inicial de todo query com DBLINK
DO $$ BEGIN
    IF (SELECT NOT dblink_exists('magno')) THEN
	PERFORM dblink_connect('magno', 'host=localhost dbname=magno user=postgres password=postgres port=5432');
    END IF;
END $$;

-- exemplo 1
SELECT * FROM
dblink('magno', 'SELECT id, transactionvalue FROM debittransaction ORDER BY id LIMIT 10')
AS t1(id bigint, transactionvalue double precision);

-- exemplo 2
SELECT * FROM 
dblink('magno', 'SELECT id, transactionvalue FROM debittransaction WHERE id = ' || 2 || ' ORDER BY id DESC LIMIT 1;')
AS t1(id bigint, transactionvalue double precision)

-- exemplo 3
SELECT * FROM 
dblink('magno', 'SELECT id, idcardholder, cardholderbalance, transactiondate FROM debittransaction WHERE idcardholder = ' || 2 || ' ORDER BY transactiondate DESC LIMIT 1;')
AS t1(id bigint, idcardholder bigint, cardholderbalance double precision, transactiondate timestamp)

dblink('magno', 'SELECT transactionvalue FROM debittransaction ORDER BY id DESC LIMIT 1;') AS t1(transactionvalue double precision);