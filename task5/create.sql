CREATE TABLE cities (
id INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(20)
);
INSERT INTO `cities` (`id`, `name`) VALUES
	(1, 'Minsk'),
	(2, 'Gomel'),
	(3, 'Hrodna'),
	(4, 'Baranovichi'),
	(5, 'Brest'),
	(6, 'Zhlobin'),
	(7, 'Vitebsk'),
	(8, 'Krugloe');
CREATE TABLE persons (
id INT PRIMARY KEY AUTO_INCREMENT,
city_id INT,
fullname VARCHAR(30),
FOREIGN KEY (city_id)  REFERENCES cities (id)
);
INSERT INTO `persons` (`id`, `city_id`, `fullname`) VALUES
	(1, 5, 'Ivan Petrov'),
	(2, 3, 'Sebastian Haponenka'),
	(3, 3, 'Vasil Lutsevich'),
	(4, 2, 'Leo Klimovich'),
	(5, 7, 'Matea Kezhman'),
	(6, 8, 'Alex Marshall'),
	(7, 3, 'Bilbo Beggins');
CREATE TABLE transactions (
transaction_id INT PRIMARY KEY AUTO_INCREMENT,
from_person_id INT,
to_person_id INT,
amount DECIMAL(20,4),
FOREIGN KEY (from_person_id)  REFERENCES persons (id) ON UPDATE CASCADE,
FOREIGN KEY (from_person_id)  REFERENCES persons (id) ON UPDATE CASCADE
);
INSERT INTO `transactions` (`transaction_id`, `from_person_id`, `to_person_id`, `amount`) VALUES
	(1, 4, 2, 10.0000),
	(2, 2, 3, 7.0000),
	(3, 5, 2, 12.5400),
	(4, 4, 7, 13.0000),
	(5, 3, 1, 8.2300),
	(6, 1, 3, 12.3000),
	(7, 2, 5, 3.1200);
