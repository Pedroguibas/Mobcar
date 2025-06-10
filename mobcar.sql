CREATE DATABASE IF NOT EXISTS mobcar;

USE mobcar;


CREATE TABLE IF NOT EXISTS endereco (
    enderecoID INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(8) NOT NULL,
    estado VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    userPassword TEXT(1000) NOT NULL,
    registerDate DATE DEFAULT CURRENT_DATE()
);

CREATE TABLE IF NOT EXISTS client (
    clientID INT,
    cnh VARCHAR(11),
    clientEnderecoID INT NOT NULL
);

ALTER TABLE client
ADD CONSTRAINT fk_client_user
FOREIGN KEY (clientID) 
REFERENCES user(userID)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE client ADD CONSTRAINT pk_client PRIMARY KEY (clientID, cnh);

ALTER TABLE client ADD CONSTRAINT fk_clientEndereco FOREIGN KEY (clientEnderecoID) REFERENCES endereco(enderecoID);


CREATE TABLE IF NOT EXISTS bankCard (
    cardID INT AUTO_INCREMENT PRIMARY KEY,
    cardName VARCHAR(255) NOT NULL,
    cardNumber VARCHAR(16) NOT NULL,
    cvv CHAR(3) NOT NULL,
    expiryDate char(5) NOT NULL
);

CREATE TABLE IF NOT EXISTS clientCard (
    clientCard_clientID INT NOT NULL,
    clientCard_cardID INT NOT NULL
);

ALTER TABLE clientCard ADD CONSTRAINT fk_clientCard_clientID FOREIGN KEY (clientCard_clientID) REFERENCES client(clientID);
ALTER TABLE clientCard ADD CONSTRAINT fk_clientCard_cardID FOREIGN KEY (clientCard_cardID) REFERENCES bankCard(cardID);
ALTER TABLE clientCard ADD CONSTRAINT pk_clientCard PRIMARY KEY (clientCard_cardID, clientCard_clientID);

CREATE TABLE IF NOT EXISTS branch (
    branchID INT AUTO_INCREMENT PRIMARY KEY,
    branchName VARCHAR(255) NOT NULL,
    branchEnderecoID INT NOT NULL
);

ALTER TABLE branch ADD CONSTRAINT fk_unidade_endereco FOREIGN KEY (branchEnderecoID) REFERENCES endereco(enderecoID);


CREATE TABLE IF NOT EXISTS car (
    carID INT AUTO_INCREMENT PRIMARY KEY,
    plate VARCHAR(7) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    price FLOAT NOT NULL,
    currentBranch INT NOT NULL,
    color VARCHAR(255) NOT NULL,
    available TINYINT(1) DEFAULT 1
);

ALTER TABLE car ADD CONSTRAINT fk_car_unidade FOREIGN KEY (currentBranch) REFERENCES branch(branchID);

CREATE TABLE IF NOT EXISTS rent (
    rentID INT AUTO_INCREMENT PRIMARY KEY,
    rentUserID INT NOT NULL,
    rentCarID INT NOT NULL,
    rentDate DATE DEFAULT CURRENT_DATE(),
    dataDevolucao DATE
);

ALTER TABLE rent ADD CONSTRAINT fk_rent_user FOREIGN KEY (rentUserID) REFERENCES user(userID);
ALTER TABLE rent ADD CONSTRAINT fk_rent_car FOREIGN KEY (rentCarID) REFERENCES car(carID);





-- PROCEDURES

DELIMITER $$
CREATE PROCEDURE insert_endereco(IN newCep VARCHAR(8), IN newEstado VARCHAR(255), IN newCidade VARCHAR(255), IN newRua VARCHAR(255), IN newNumero VARCHAR(255))
BEGIN
	IF EXISTS(SELECT * FROM endereco WHERE cep = newCep AND numero = newNumero) THEN
    	BEGIN
        	SELECT enderecoID FROM endereco WHERE cep = newCep AND numero = newNumero;
        END;
    ELSE
    	BEGIN
        	INSERT INTO endereco (estado, cidade, rua, numero, cep) VALUES (newEstado, newCidade, newRua, newNumero, newCep);
        	SELECT enderecoID FROM endereco WHERE cep = newCep AND numero = newNumero;
        END;
    END IF;
END$$
DELIMITER ;





-- VIEWS

CREATE VIEW vw_client AS
SELECT 
	U.userID,
    U.userName,
    U.email,
    U.registerDate,
    E.cep,
    E.estado,
    E.cidade,
    E.rua,
    E.numero,
    C.cnh
FROM user U
INNER JOIN client C ON C.clientID = U.userID
INNER JOIN endereco E ON E.enderecoID = C.clientEnderecoID;





CREATE USER IF NOT EXISTS mobcar IDENTIFIED BY '911643';
GRANT ALL ON mobcar.* TO mobcar IDENTIFIED BY '911643';