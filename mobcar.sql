CREATE DATABASE IF NOT EXISTS mobcar;

USE mobcar;


CREATE TABLE IF NOT EXISTS endereco (
    enderecoID INT AUTO_INCREMENT PRIMARY KEY,
    estado ENUM('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO') NOT NULL,
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
    CLIENTEnderecoID INT NOT NULL
);

ALTER TABLE client ADD CONSTRAINT pk_client PRIMARY KEY (clientID, cnh);

ALTER TABLE client ADD CONSTRAINT fk_clientEndereco FOREIGN KEY (clientEnderecoID) REFERENCES endereco(enderecoID);

ALTER TABLE client
ADD CONSTRAINT fk_client_user
FOREIGN KEY (clientID) 
REFERENCES user(userID)
ON DELETE CASCADE
ON UPDATE CASCADE;

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
    rentUserID INT NOT NULL,
    rentCarID INT NOT NULL,
    rentDate DATE DEFAULT CURRENT_DATE(),
    dataDevolucao DATE
);

ALTER TABLE RENT ADD CONSTRAINT pk_rent PRIMARY KEY (rentUserID, rentCarID);
ALTER TABLE rent ADD CONSTRAINT fk_rent_user FOREIGN KEY (rentUserID) REFERENCES user(userID);
ALTER TABLE rent ADD CONSTRAINT fk_rent_car FOREIGN KEY (rentCarID) REFERENCES car(carID);






CREATE USER IF NOT EXISTS mobcar IDENTIFIED BY '911643';
GRANT ALL ON mobcar.* TO mobcar IDENTIFIED BY '911643';