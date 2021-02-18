 /**/
 /*TABLE table_example*/
 /**/
 create table table_example(
 id INTEGER NOT NULL,
 registration_date timestamp DEFAULT CURRENT_TIMESTAMP,
 name text,
 last_name text,
 primary key(id)
 ); 
