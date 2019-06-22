# SQL file in YoctoWeb project

`.sql` file isn't commited in repository, but the `.psql` is committed.
`.psql`file is a sql file with table name prefixed by `__PREFIX__` and can be 
automaticaly converted to `.sql` standard by the command `make sql/aaaaa.sql`
or with specific prefix `DB_PREFIX="myPrefix_" make sql/aaaaa.sql`.
