create table MadSurfLog (
		no bigint unsigned auto_increment primary key,
		relNo bigint unsigned not null,
		page varchar(255),
		wDate timestamp default CURRENT_TIMESTAMP
);
