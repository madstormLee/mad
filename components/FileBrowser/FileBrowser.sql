create table FileBrowser (
		id integer unsigned auto_increment primary key,
		userId varchar(42) not null,
		link varchar(255) not null,
		ext char(4) not null,
		name varchar(255) not null,
		brief varchar(255) not null,
		wDate datetime not null,
		uDate timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP
		);
