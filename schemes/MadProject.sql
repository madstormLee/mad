create table MadProject (
		no integer unsigned auto_increment primary key,
		projectName varchar(100),
		goal varchar(255),
		brief text,
		s_date date,
		e_date date,
		progress tinyint unsigned,
		developers smallint unsigned,
		PM varchar(50),
		cheifProgrammer varchar(50),
		cheifDesigner varchar(50)
		);
