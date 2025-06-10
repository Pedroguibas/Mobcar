CREATE DATABASE IF NOT EXISTS mobcar;

USE mobcar;


CREATE TABLE IF NOT EXISTS address (
    addressID INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(8) NOT NULL,
    state VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    street VARCHAR(255) NOT NULL,
    number VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS user (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    userPassword CHAR(32) NOT NULL,
    registerDate DATE DEFAULT CURRENT_DATE()
);

CREATE TABLE IF NOT EXISTS client (
    clientID INT,
    cnh VARCHAR(11),
    clientAddressID INT NOT NULL
);

ALTER TABLE client
ADD CONSTRAINT fk_client_user
FOREIGN KEY (clientID) 
REFERENCES user(userID)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE client ADD CONSTRAINT pk_client PRIMARY KEY (clientID, cnh);

ALTER TABLE client ADD CONSTRAINT fk_clientAddress FOREIGN KEY (clientAddressID) REFERENCES address(addressID);


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
    branchAddressID INT NOT NULL
);

ALTER TABLE branch ADD CONSTRAINT fk_unidade_address FOREIGN KEY (branchAddressID) REFERENCES address(addressID);


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
CREATE PROCEDURE insert_address(
    IN newCep VARCHAR(8),
    IN newState VARCHAR(255),
    IN newCity VARCHAR(255),
    IN newStreet VARCHAR(255),
    IN newNumber VARCHAR(255),
    OUT newAddressID INT
)
BEGIN
	IF EXISTS(SELECT * FROM address WHERE cep = newCep AND number = newNumber) THEN
    	BEGIN
        	SELECT addressID FROM address WHERE cep = newCep AND number = newNumber;
        END;
    ELSE
    	BEGIN
        	INSERT INTO address (cep, state, city, street, number) VALUES (newCep, newState, newCity, newStreet, newNumber);
        	SELECT addressID FROM address WHERE cep = newCep AND number = newNumber INTO newAddressID;
        END;
    END IF;
END$$

CREATE PROCEDURE insert_client(
    IN newEmail VARCHAR(255),
    IN newUserName VARCHAR(255),
    IN newPassword CHAR(32),
    IN newCnh VARCHAR(11),
    IN newCep VARCHAR(8),
    IN newState VARCHAR(255),
    IN newCity VARCHAR(255), 
    IN newStreet VARCHAR(255),
    IN newNumber VARCHAR(255))
BEGIN
    DECLARE newAddressID INT;

    INSERT INTO user (userName, email, userPassword) VALUES (newUserName, newEmail, MD5(newPassword));

    CALL insert_address(newCep, newState, newCity, newStreet, newNumber, newAddressID);

    INSERT INTO client (clientID, cnh, clientAddressID)
    VALUES (
        (SELECT userID FROM user WHERE email = newEmail AND userName = newUserName AND userPassword = MD5(newPassword)),
        newCnh,
        newAddressID
    );

END$$

DELIMITER ;







-- VIEWS

CREATE VIEW vw_client AS
SELECT 
	U.userID,
    U.userName,
    U.email,
    U.registerDate,
    U.userPassword,
    E.cep,
    E.state,
    E.city,
    E.street,
    E.number,
    C.cnh
FROM user U
INNER JOIN client C ON C.clientID = U.userID
INNER JOIN address E ON E.addressID = C.clientAddressID;





CREATE USER IF NOT EXISTS mobcar IDENTIFIED BY '911643';
GRANT ALL ON mobcar.* TO mobcar IDENTIFIED BY '911643';