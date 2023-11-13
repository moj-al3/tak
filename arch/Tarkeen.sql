DROP
DATABASE IF EXISTS Tarkeen;
CREATE
DATABASE Tarkeen;

SET
SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET
time_zone
= "+00:00";

--
-- Table structure for table UserTypes
--

CREATE TABLE Tarkeen.UserTypes
(
    user_type_id int(128) NOT NULL
        AUTO_INCREMENT,
    `name`       varchar(10) NOT NULL,
    PRIMARY KEY
        (user_type_id)

);


--
-- Table structure for table Users
--

CREATE TABLE Tarkeen.Users
(
    user_id            int(128) NOT NULL,
    first_name         varchar(50)  NOT NULL,
    last_name          varchar(50)  NOT NULL,
    `password`         varchar(250) NOT NULL,
    email              varchar(250) NOT NULL,
    user_type_id       int (128) NOT NULL,
    reset_token        varchar(50),
    reset_token_expiry datetime,
    PRIMARY KEY
        (user_id),
    FOREIGN KEY
        (user_type_id) REFERENCES Tarkeen.UserTypes
        (user_type_id)
);



--
-- Table structure for table Cars
--

CREATE TABLE Tarkeen.Cars
(
    car_id    int(128) NOT NULL
        AUTO_INCREMENT,
    car_type  varchar(15) NOT NULL,
    car_plate varchar(15) NOT NULL,
    owner_id  int (128) NOT NULL,
    deleted   tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY
        (car_id),
    FOREIGN KEY
        (owner_id) REFERENCES Tarkeen.Users
        (user_id)
);


-- --
-- -- Table structure for table ParkingSpots
-- --

CREATE TABLE Tarkeen.ParkingSpots
(
    parking_id     int(128) NOT NULL
        AUTO_INCREMENT,
    zone_number    varchar(10) NOT NULL,
    floor_number   int (10) NOT NULL,
    parking_number int (10) NOT NULL,
    PRIMARY KEY
        (parking_id)
);

-- --
-- -- Table structure for table Reservation
-- --

CREATE TABLE Tarkeen.Reservation
(
    reservation_id       int(128) NOT NULL
        AUTO_INCREMENT,
    reservation_datetime datetime NOT NULL,
    extensions_count     int (10) DEFAULT 0,
    enter_datetime       datetime (6),
    exit_datetime        datetime (6),
    parking_id           int (128) NOT NULL,
    car_id               int (128) NOT NULL,
    reserver_id          int (128) NOT NULL,
    PRIMARY KEY
        (reservation_id),
    FOREIGN KEY
        (parking_id) REFERENCES Tarkeen.ParkingSpots
        (parking_id),
    FOREIGN KEY
        (car_id) REFERENCES Tarkeen.Cars
        (car_id),
    FOREIGN KEY
        (reserver_id) REFERENCES Tarkeen.Users
        (user_id)
);



--
-- Table structure for table FeedBacks
--

CREATE TABLE Tarkeen.FeedBacks
(
    feedback_id    int(128) NOT NULL
        AUTO_INCREMENT,
    reservation_id int (128) NOT NULL,
    rating_scale   int (8) NOT NULL,
    PRIMARY KEY
        (feedback_id),
    FOREIGN KEY
        (reservation_id) REFERENCES Tarkeen.Reservation
        (reservation_id)
);


-- --
-- -- Table structure for table ViolationTypes
-- --

CREATE TABLE Tarkeen.ViolationTypes
(
    violation_type_id int(128) NOT NULL
        AUTO_INCREMENT,
    `name`            varchar(256) NOT NULL,
    number_of_days    int(128),
    PRIMARY KEY
        (violation_type_id)
);

-- --
-- -- Table structure for table Violations
-- --

CREATE TABLE Tarkeen.Violations
(
    violation_id           int(128) NOT NULL
        AUTO_INCREMENT,
    violation_datetime     datetime NOT NULL,
    violation_end_datetime datetime NOT NULL,
    car_id                 int (128) NOT NULL,
    violation_type_id      int (128) NOT NULL,
    violator_id            int (128) NOT NULL,
    violated_id            int (128) NOT NULL,
    note                   varchar(256),

    PRIMARY KEY
        (violation_id),
    FOREIGN KEY
        (car_id) REFERENCES Tarkeen.Cars
        (car_id),
    FOREIGN KEY
        (violation_type_id) REFERENCES Tarkeen.ViolationTypes
        (violation_type_id),
    FOREIGN KEY
        (violator_id) REFERENCES Tarkeen.Users
        (user_id),
    FOREIGN KEY
        (violated_id) REFERENCES Tarkeen.Users
        (user_id)
);

-- --
-- -- Inserting Data
-- --
-- -- UserTypes

INSERT INTO Tarkeen.UserTypes
    (user_type_id, `name`)
VALUES (1, 'KFU_MEMBER'),
       (2, 'VISITOR'),
       (3, 'SECURITY');

--
-- -- Users
--

INSERT INTO Tarkeen.Users
    (user_id, first_name, last_name, `password`, user_type_id, email)
VALUES (11100098, 'bayan', 'ali', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 1,
        'bayan@hotmail.com'),
       (220006286, 'marya', 'alsayed', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 2,
        'marya@gmail.com'),
       (221009887, 'saleh', 'alsayed', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 3,
        'saleh@gmail.com'),
       (220008788, 'lela', 'alahmad', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 1,
        'lely764@gmail.com'),
       (878287269, 'ali', 'alhaddad', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 2,
        'aliaalhhaddad@gmail.com ');


--
-- -- Cars
--

INSERT INTO Tarkeen.Cars
    (car_id, car_type, car_plate, owner_id)
VALUES (1, 'jeep', '285-qas', 11100098),
       (2, 'ford', '854-mbn', 220006286),
       (3, 'ford', '874-pik', 220008788),
       (4, 'porsche', '774-qxs', 878287269);
--
-- --ParkingSpots
--
INSERT INTO Tarkeen.ParkingSpots
(zone_number, floor_number, parking_number)
VALUES
    -- Zone A
    ('A', 1, 1), ('A', 1, 2), ('A', 1, 3), ('A', 1, 4), ('A', 1, 5), ('A', 1, 6), ('A', 1, 7), ('A', 1, 8), ('A', 1, 9),
    ('A', 2, 1), ('A', 2, 2), ('A', 2, 3), ('A', 2, 4), ('A', 2, 5), ('A', 2, 6), ('A', 2, 7), ('A', 2, 8), ('A', 2, 9),
    ('A', 3, 1), ('A', 3, 2), ('A', 3, 3), ('A', 3, 4), ('A', 3, 5), ('A', 3, 6), ('A', 3, 7), ('A', 3, 8), ('A', 3, 9),
    -- Zone B
    ('B', 1, 1), ('B', 1, 2), ('B', 1, 3), ('B', 1, 4), ('B', 1, 5), ('B', 1, 6), ('B', 1, 7), ('B', 1, 8), ('B', 1, 9),
    ('B', 2, 1), ('B', 2, 2), ('B', 2, 3), ('B', 2, 4), ('B', 2, 5), ('B', 2, 6), ('B', 2, 7), ('B', 2, 8), ('B', 2, 9),
    ('B', 3, 1), ('B', 3, 2), ('B', 3, 3), ('B', 3, 4), ('B', 3, 5), ('B', 3, 6), ('B', 3, 7), ('B', 3, 8), ('B', 3, 9),
    -- Zone C
    ('C', 1, 1), ('C', 1, 2), ('C', 1, 3), ('C', 1, 4), ('C', 1, 5), ('C', 1, 6), ('C', 1, 7), ('C', 1, 8), ('C', 1, 9),
    ('C', 2, 1), ('C', 2, 2), ('C', 2, 3), ('C', 2, 4), ('C', 2, 5), ('C', 2, 6), ('C', 2, 7), ('C', 2, 8), ('C', 2, 9),
    ('C', 3, 1), ('C', 3, 2), ('C', 3, 3), ('C', 3, 4), ('C', 3, 5), ('C', 3, 6), ('C', 3, 7), ('C', 3, 8), ('C', 3, 9),
    -- Zone D
    ('D', 1, 1), ('D', 1, 2), ('D', 1, 3), ('D', 1, 4), ('D', 1, 5), ('D', 1, 6), ('D', 1, 7), ('D', 1, 8), ('D', 1, 9),
    ('D', 2, 1), ('D', 2, 2), ('D', 2, 3), ('D', 2, 4), ('D', 2, 5), ('D', 2, 6), ('D', 2, 7), ('D', 2, 8), ('D', 2, 9),
    ('D', 3, 1), ('D', 3, 2), ('D', 3, 3), ('D', 3, 4), ('D', 3, 5), ('D', 3, 6), ('D', 3, 7), ('D', 3, 8), ('D', 3, 9),
    -- Zone E
    ('E', 1, 1), ('E', 1, 2), ('E', 1, 3), ('E', 1, 4), ('E', 1, 5), ('E', 1, 6), ('E', 1, 7), ('E', 1, 8), ('E', 1, 9),
    ('E', 2, 1), ('E', 2, 2), ('E', 2, 3), ('E', 2, 4), ('E', 2, 5), ('E', 2, 6), ('E', 2, 7), ('E', 2, 8), ('E', 2, 9),
    ('E', 3, 1), ('E', 3, 2), ('E', 3, 3), ('E', 3, 4), ('E', 3, 5), ('E', 3, 6), ('E', 3, 7), ('E', 3, 8), ('E', 3, 9),
    -- Zone F
    ('F', 1, 1), ('F', 1, 2), ('F', 1, 3), ('F', 1, 4), ('F', 1, 5), ('F', 1, 6), ('F', 1, 7), ('F', 1, 8), ('F', 1, 9),
    ('F', 2, 1), ('F', 2, 2), ('F', 2, 3), ('F', 2, 4), ('F', 2, 5), ('F', 2, 6), ('F', 2, 7), ('F', 2, 8), ('F', 2, 9),
    ('F', 3, 1), ('F', 3, 2), ('F', 3, 3), ('F', 3, 4), ('F', 3, 5), ('F', 3, 6), ('F', 3, 7), ('F', 3, 8), ('F', 3, 9);

--
-- --Reservation
--
INSERT INTO Tarkeen.Reservation
(reservation_id, reservation_datetime, extensions_count, enter_datetime,
 exit_datetime, parking_id, car_id, reserver_id)
VALUES (1, '2023-09-20T00:00:00', NULL, '2023-09-2T8:30:11', '2023-09-20 15:30:12', 1, 1, 11100098),
       (2, '2023-09-22T00:00:00', NULL, '2023-09-22T12:30:11', '2023-09-22 15:35:12', 2, 2, 220006286),
       (3, '2023-09-24T00:00:00', NULL, '2023-09-24T15:30:11', '2023-09-24 16:30:12', 3, 3, 220008788),
       (4, '2023-09-25T00:00:00', NULL, '2023-09-25T9:30:11', '2023-09-25 10:30:12', 4, 4, 878287269);
--
-- --FeedBacks
--
INSERT INTO Tarkeen.FeedBacks
    (feedback_id, reservation_id, rating_scale)
VALUES (1, 1, 4),
       (2, 2, 5),
       (3, 3, 5),
       (4, 4, 2);
--
-- ViolationTypes
--

INSERT INTO Tarkeen.ViolationTypes (violation_type_id, `name`, number_of_days)
VALUES (1, 'Exceeding the time allowed for parking', 1),
       (2, 'Parked on a wrong parking', 2),
       (3, 'Parked for full day', 3);

-- Violation
--

INSERT INTO Tarkeen.Violations
(violation_id, violation_datetime, violation_end_datetime, car_id, violation_type_id, violator_id, violated_id)
VALUES (1, '2023-09-22T00:00:00', '2023-09-23T00:00:00', 1, 1, 220006286, 221009887),
       (2, '2023-09-24T00:00:00', '2023-09-27T00:00:00', 1, 3, 220008788, 221009887),
       (3, '2023-09-25T00:00:00', '2023-09-28T00:00:00', 2, 3, 220008788, 878287269);

COMMIT;
