create table instant_log (
	no smallint unsigned primary key,
	id char(16),
	pw char(16),
	ip char(15), 
	last_logged date,
	log_counter tinyint unsigned
)
