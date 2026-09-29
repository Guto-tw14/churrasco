create database churrasco;
use churrasco;

create table usuarios(
    id int primary key auto_increment,
    nome varchar(100) not null,
    email varchar(100) not null unique,
    senha varchar(255) not null
);

create table participantes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    telefone VARCHAR(20),
    tipo_churrasco VARCHAR(30) NOT NULL,
    acompanhamento VARCHAR(50),
    confirmado BOOLEAN NOT NULL,
    pago BOOLEAN NOT NULL
);

insert into usuarios (nome, email, senha) values
('augusto', 'augusto@email.com', '$2y$10$o.EIJ.bqajROmddPQY0yNeI8zcQqId6jHqUu/lWgoQUxA6RI9S5P6'),
('vitor', 'vitor@email.com', '$2y$10$/SDJ1v.edmdyp3/7ZGVN0usLhVilU0Ps0pfVkzzeXPXUpF.3ECUnG');