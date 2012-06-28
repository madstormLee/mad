create table MadCRM (
		no integer unsigned auto_increment primary key,
		ordno integer unsigned,
		id varchar(42),
		title varchar(255),
		content text,
		kind tinyint default 0,
		accomplished tinyint default 0,
		w_date datetime
		);
