create table MadCounter (
		no bigint unsigned auto_increment primary key,
		ip char(15),
		agent varchar(255),
		referer varchar(255),
		wDate timestamp default CURRENT_TIMESTAMP
		);
