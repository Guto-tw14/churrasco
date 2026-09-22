create database churrasco;
use churrasco;

create table usuarios(
    id int primary key auto_increment,
    nome varchar(100) not null,
    email varchar(100) not null unique,
    senha varchar(100) not null
);

create table participantes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    telefone VARCHAR(20),
    tipo_churrasco VARCHAR(30) NOT NULL,
    acompanhamento VARCHAR(50),
    confirmado BOOLEAN NOT NULL
    pago BOOLEAN NOT NULL
);

insert into usuarios (nome, email, senha) values
('augusto', 'augusto@email.com', '1234'),
('vitor', 'vitor@email.com', '1234');