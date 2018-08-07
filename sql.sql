create schema cadastros default char set utf8;

use cadastros;

create table usuarios(
	id int not null,
	nome varchar(100) not null,
    sobrenome varchar(100) not null,
    sexo varchar(60),
    turma varchar(60),
    email varchar(255),
    username varchar(255),
    senha varchar(500),
    salt int,
	primary key(id)
);

create table mensagens(
	remetente int not null,
    destinatario int not null,
    mensagem text not null,
    data varchar(255) not null
);

create table grupos(
	id int not null AUTO_INCREMENT,
    nome varchar(255) not null,
    
    primary key(id)
);

create table adicaonogp(
	id_grupo int not null,
    id_participante int not null,
    
    primary key(id_grupo, id_participante),
    foreign key(id_grupo) references grupos(id),
    foreign key(id_participante) references usuarios(id)
);

insert into grupos(nome)
	values('Terceiro');
    
insert into adicaonogp(id_grupo, id_participante)
	values(1, 1),
     (1, 2),
     (1, 3);
	
insert into grupos(nome)
	values('Segundo'),
    values('Primeiro'),
    values('Licenciatura');
    
select nome, sobrenome from usuarios;

insert into adicaonogp(id_grupo, id_participante)
	values(4, 6),
     (4, 5),
     (4, 4);
        
