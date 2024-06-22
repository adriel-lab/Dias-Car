--
-- File generated with SQLiteStudio v3.4.4 on qui jun 13 10:10:28 2024
--
-- Text encoding used: System
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Table: servicos
CREATE TABLE IF NOT EXISTS servicos (
    id                   INTEGER         PRIMARY KEY AUTOINCREMENT,
    carro_id             INTEGER         NOT NULL,
    descricao            TEXT            NOT NULL,
    data                 TEXT            NOT NULL,
    total_servicos_valor DECIMAL (10, 2) NOT NULL,
    valor                DECIMAL (10, 2) NOT NULL,
    mao_de_obra_valor    DECIMAL (10, 2) NOT NULL,
    servico_descricao_0  TEXT            NOT NULL,
    servico_valor_0      DECIMAL (10, 2) NOT NULL,
    servico_descricao_1  TEXT            NOT NULL,
    servico_valor_1      DECIMAL (10, 2) NOT NULL,
    servico_descricao_2  TEXT            NOT NULL,
    servico_valor_2      DECIMAL (10, 2) NOT NULL,
    total_valor          DECIMAL (10, 2) NOT NULL,
    FOREIGN KEY (
        carro_id
    )
    REFERENCES carros (id) 
);


COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
