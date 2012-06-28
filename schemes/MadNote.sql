create table MadNote (
		no integer unsigned auto_increment primary key,
		uri varchar(255),
		x smallint,
		y smallint,
		width smallint,
		height smallint,
		writer varchar(42),
		content text,
		w_date datetime
		);
