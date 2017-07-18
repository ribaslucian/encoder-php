:: arg %1 host
:: arg %2 user
:: arg %3 pass
:: arg %4 database
:: arg %5 path to save file

@echo off
SET PGPASSWORD=%3
echo on
"C:\Program Files\PostgreSQL\9.5\bin\pg_dump.exe" --format=c --dbname=%4 --host=%1 --username=%2 --inserts > %5