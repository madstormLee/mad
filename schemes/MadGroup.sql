create table MadGroup (
		no smallint unsigned auto_increment primary key,
		relNo smallint unsigned not null default 0,
		orderNo smallint unsigned not null default 0,
		depth smallint unsigned not null default 1,
		id varchar(40),
		name varchar(40),
		brief varchar(255),
		wDate datetime,
		uDate timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP 
		);
