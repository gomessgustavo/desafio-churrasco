DROP DATABASE desafiochurrasco;
CREATE DATABASE desafiochurrasco;
USE desafiochurrasco;

CREATE TABLE funcionario(
	id INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
	email VARCHAR(150) NOT NULL UNIQUE,
	senha VARCHAR(200) NOT NULL,    
	presenca ENUM('sim','nao'),
	bebe ENUM('sim','nao'),
	PRIMARY KEY (id)
) ENGINE InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

CREATE TABLE convidado (
	id int(11) NOT NULL AUTO_INCREMENT,
	nome VARCHAR(150) NOT NULL,
	bebeConvidado ENUM('sim','nao'),
	email VARCHAR(150) NOT NULL,
	PRIMARY KEY(id)
)