create table reginfo_expanded(
	id char(16) not null unique,
	id_no bigint unsigned,
	tel bigint unsigned,
	zipcode mediumint unsigned,
	address varchar(200)
)
