-- Active: 1751042571760@@127.0.0.1@3307
CREATE DATABASE ecoride;
USE ecoride;

CREATE TABLE role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    name_role VARCHAR(255)
);
CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name_user VARCHAR(255),
    lastname_user VARCHAR(255),
    dob_user DATE,
    email_user VARCHAR(255),
    password_user VARCHAR(255),
    phone_user VARCHAR(12),
    postcode_user VARCHAR(10),
    photo_user VARCHAR(255),
    credit_user INT,
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES role(id_role)
);



INSERT INTO role (name_role) VALUES 
("chauffeur"),
("passager"),
("chauffeur-passager");


INSERT INTO role (name_role) VALUES 
("admin"),
("employe");


CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    name_admin VARCHAR(255),
    lastname_admin VARCHAR(255),
    email_admin VARCHAR(255),
    password_admin VARCHAR(255),
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES role(id_role)
);



CREATE TABLE employee (
    id_employee INT AUTO_INCREMENT PRIMARY KEY,
    name_employee VARCHAR(255),
    lastname_employee VARCHAR(255),
    email_employee VARCHAR(255),
    password_employee VARCHAR(255),
    dateHire_employee DATE,
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES role(id_role)
);



CREATE TABLE car (
    id_car INT AUTO_INCREMENT PRIMARY KEY,
    brand_car VARCHAR(255),
    model_car VARCHAR(255),
    color_car VARCHAR(255),
    year_car DATE,
    energy_car VARCHAR(255),
    licensePlate_car VARCHAR(10),
    firstPlate_car DATE,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

ALTER TABLE car
MODIFY COLUMN year_car YEAR;

CREATE TABLE carpooling (
    id_carpooling INT AUTO_INCREMENT PRIMARY KEY,
    departure_date DATE,
    arrival_date DATE,
    departure_hour TIME,
    arrival_hour TIME,
    departure_city VARCHAR(255),
    arrival_city VARCHAR(255),
    nb_place INT,
    price_place INT,
    id_car INT,
    FOREIGN KEY (id_car) REFERENCES car(id_car)
);

CREATE TABLE Participer (
    id_carpooling INT,
    id_user INT,
    PRIMARY KEY (id_carpooling, id_user),
    FOREIGN KEY (id_carpooling) REFERENCES carpooling(id_carpooling),
    FOREIGN KEY (id_user) REFERENCES user(id_user)
);

CREATE TABLE reviews (
    id_reviews INT AUTO_INCREMENT PRIMARY KEY,
    note_reviews INT,
    date_reviews DATE,
    comment_reviews TEXT,
    status_reviews VARCHAR(255),
    id_user INT,
    id_carpooling INT,
    id_employee INT,
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_carpooling) REFERENCES carpooling(id_carpooling),
    FOREIGN KEY (id_employee) REFERENCES employee(id_employee)
);

CREATE TABLE user_preferences (
    id_preferences INT AUTO_INCREMENT PRIMARY KEY,
    smoker BOOL,
    pet BOOL
);

CREATE TABLE Avoir (
    id_user INT,
    id_preferences INT,
    PRIMARY KEY (id_user, id_preferences),
    FOREIGN KEY (id_user) REFERENCES user(id_user),
    FOREIGN KEY (id_preferences) REFERENCES user_preferences(id_preferences)
);

ALTER TABLE user ADD avatar_user VARCHAR(255);

ALTER TABLE car ADD photo_car VARCHAR(255);

ALTER TABLE carpooling
ADD COLUMN info_carpooling TEXT;

DROP TABLE user_preferences;

DROP TABLE Avoir;

CREATE TABLE user_preferences (
    id_preference INT AUTO_INCREMENT PRIMARY KEY,
    preference_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE user_has_preferences (
    id_user INT NOT NULL,
    id_preference INT NOT NULL,
    PRIMARY KEY (id_user, id_preference),
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_preference) REFERENCES user_preferences(id_preference) ON DELETE CASCADE
);

INSERT INTO user_preferences (id_preference, preference_name) VALUES
(1, 'smoker'),
(2, 'pet'),
(3, 'Music'),
(4, 'speak');

DROP TABLE Participer;

CREATE TABLE Participer (
    id_participation INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_carpooling INT NOT NULL,
    date_reservation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_carpooling) REFERENCES carpooling(id_carpooling) ON DELETE CASCADE,
    UNIQUE KEY unique_reservation (id_user, id_carpooling)
);

ALTER TABLE carpooling ADD COLUMN driver_id INT NOT NULL;

ALTER TABLE carpooling MODIFY driver_id INT NOT NULL;

UPDATE carpooling SET driver_id = 3;  
ALTER TABLE carpooling
ADD CONSTRAINT fk_driver
FOREIGN KEY (driver_id)
REFERENCES user(id_user)
ON DELETE CASCADE;

SELECT driver_id FROM carpooling
WHERE driver_id IS NOT NULL
AND driver_id NOT IN (SELECT id_user FROM user);

UPDATE carpooling c
JOIN car ca ON c.id_car = ca.id_car
SET c.driver_id = ca.id_user;


CREATE TABLE platform_earnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_carpooling INT NOT NULL,
    credits_earned INT NOT NULL DEFAULT 0,
    earned_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_carpooling) REFERENCES carpooling(id_carpooling) ON DELETE CASCADE
);









        /*test*/
SELECT * FROM user;

INSERT INTO car (brand_car, model_car, color_car, year_car, energy_car, licensePlate_car, firstPlate_car, id_user) 
VALUES (
    'Peugeot', 
    '208', 
    'Bleu', 
    '2018', 
    'Essence', 
    'AB123CD', 
    '2018-03-15', 
    1
);

DELETE FROM car
WHERE id_car = 1;

SELECT name_role FROM role WHERE id_role= 1;

SELECT * FROM user WHERE id_user = 1;

SELECT * FROM car WHERE id_user= 4;



SELECT * FROM car WHERE id_user = 4;
SELECT * FROM car c LEFT JOIN user u ON u.id_user = c.id_user WHERE id_car = 1;

SELECT DISTINCT driver_id FROM carpooling
WHERE driver_id NOT IN (SELECT id_user FROM user);
