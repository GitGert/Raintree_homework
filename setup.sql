DROP DATABASE insurance_db;
CREATE DATABASE IF NOT EXISTS insurance_db;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS insurance;

DROP TABLE IF EXISTS  patient;

SET FOREIGN_KEY_CHECKS = 1;

USE insurance_db;

CREATE TABLE IF NOT EXISTS patient (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pn VARCHAR(11) DEFAULT NULL,
    first VARCHAR(15) DEFAULT NULL,
    last VARCHAR(25) DEFAULT NULL,
    dob DATE DEFAULT NULL
);


CREATE TABLE IF NOT EXISTS insurance (
    _id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    patient_id INT(10) UNSIGNED NOT NULL,
    iname VARCHAR(40) DEFAULT NULL,
    from_date DATE DEFAULT NULL,
    to_date DATE DEFAULT NULL,
    FOREIGN KEY (patient_id) REFERENCES patient(_id)
);

INSERT INTO patient (pn, first, last, dob) VALUES ('1', 'John', 'Doe', '1980-01-01');
INSERT INTO patient (pn, first, last, dob) VALUES ('2', 'Jane', 'Smith', '1985-02-02');
INSERT INTO patient (pn, first, last, dob) VALUES ('3', 'Alice', 'Johnson', '1990-03-03');
INSERT INTO patient (pn, first, last, dob) VALUES ('4', 'Bob', 'Williams', '1995-04-04');
INSERT INTO patient (pn, first, last, dob) VALUES ('5', 'Charlie', 'Brown', '2000-05-05');



-- John Doe's Insurance Records
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (1, 'Policy A', '2020-06-01', '2023-06-01');
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (1, 'Policy B', '2021-06-01', '2024-06-01');

-- Jane Smith's Insurance Records
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (2, 'Policy C', '2020-06-01', '2023-06-01');
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (2, 'Policy D', '2021-06-01', '2024-06-01');

-- Alice Johnson's Insurance Records
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (3, 'Policy E', '2020-06-01', '2023-06-01');
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (3, 'Policy F', '2021-06-01', '2024-06-01');

-- Bob Williams's Insurance Records
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (4, 'Policy G', '2020-09-01', '2023-09-01');
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (4, 'Policy H', '2021-09-01', '2024-09-01');

-- Charlie Brown's Insurance Records
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (5, 'Policy I', '2020-10-01', '2023-10-01');
INSERT INTO insurance (patient_id, iname, from_date, to_date) VALUES (5, 'Policy J', '2021-10-01', '2024-10-01');
