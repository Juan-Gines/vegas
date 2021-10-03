-- Base de datos del casino 
CREATE DATABASE casino DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE casino;

CREATE TABLE usuarios (usu_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    usu_email VARCHAR(500) NOT NULL UNIQUE,
    usu_password VARCHAR(256) NOT NULL,
    usu_nick VARCHAR(100) NOT NULL UNIQUE,
    usu_nivel TINYINT UNSIGNED NOT NULL DEFAULT 1,
    usu_fnacimiento DATETIME NOT NULL,
    usu_puntos DECIMAL(12,2) NOT NULL DEFAULT 10000,
    usu_reclamar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    usu_fregistro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP);

CREATE TABLE partidas (par_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    par_tipo VARCHAR(100) NOT NULL,
    par_finicio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    par_ffin DATETIME);

CREATE TABLE apuesta_bj (apubj_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    apubj_seguro DECIMAL(12,2) DEFAULT 0,
    apubj_normal DECIMAL(12,2),
    apubj_doble DECIMAL(12,2) DEFAULT 0,
    apubj_abre DECIMAL(12,2) DEFAULT 0,
    apubj_gana DECIMAL(12,2) DEFAULT 0,
    apubj_pierde DECIMAL(12,2) DEFAULT 0,
    apubj_resultado DECIMAL(12,2));

CREATE TABLE blackjack (bj_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    par_id INT NOT NULL,
    usu_id INT NOT NULL,
    apubj_id INT NOT NULL,
    bj_cupier VARCHAR(50) NOT NULL,
    bj_jugador VARCHAR(50) NOT NULL,
    bj_fregistro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY fk_blackjack_usuarios (usu_id) REFERENCES usuarios(usu_id),
    FOREIGN KEY fk_blackjack_partidas (par_id) REFERENCES partidas(par_id),
    FOREIGN KEY fk_blackjack_apuesta_bj (apubj_id) REFERENCES apuesta_bj(apubj_id));

CREATE TABLE tokens (tok_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,    
    usu_id INT NOT NULL,
    tok_token VARCHAR(256) NOT NULL UNIQUE,
    tok_fe_token DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY fk_tokens_usuarios (usu_id) REFERENCES usuarios (usu_id));   

INSERT INTO usuarios (usu_email,usu_password,usu_nick,usu_fnacimiento)
    VALUES ('juangalenta@hotmail.com','$2y$10$6JqABKJKwBkUWbfw7GV6Z.kIaEDOYFssZvCa3pd9ExMBoPSRuQ9oq','Juan','1974-8-8'),
    ('raquel@hotmail.com','$2y$10$6JqABKJKwBkUWbfw7GV6Z.kIaEDOYFssZvCa3pd9ExMBoPSRuQ9oq','Raquel','1974-5-21');

INSERT INTO partidas (par_tipo)
    VALUES ('blackjack'),
    ('blackjack'),
    ('blackjack');

INSERT INTO apuesta_bj (apubj_normal,apubj_gana,apubj_resultado)
    VALUES (10,10,10),
    (5,5,5);

INSERT INTO apuesta_bj (apubj_normal,apubj_pierde,apubj_resultado)
    VALUES (10,10,-10);

INSERT INTO blackjack(par_id,usu_id,apubj_id,bj_cupier,bj_jugador)
    VALUES (1,2,1,'26,10c,6p,12r','19,11p,8c'),
    (2,1,2,'26,10c,6p,12r','19,11p,8c'),
    (3,1,3,'19,11p,8c','26,10c,6p,12r');

CREATE USER 'webcasino'@'localhost' IDENTIFIED BY 'n1AcJu';

GRANT SELECT,UPDATE,INSERT ON casino.* TO 'webcasino'@'localhost';

CREATE USER 'juangi'@'localhost' IDENTIFIED BY 'nD10SAcMa';

GRANT ALL PRIVILEGES ON casino.* TO 'juangi'@'localhost';