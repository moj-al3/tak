DROP DATABASE IF EXISTS Tarkeen;
CREATE DATABASE Tarkeen;

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone
= "+00:00";

--
-- Table structure for table UserTypes
--

CREATE TABLE Tarkeen.UserTypes
(
	user_type_id int(128) NOT NULL
	AUTO_INCREMENT,
  `name` varchar
	(10) NOT NULL,
  PRIMARY KEY
	(user_type_id)
  
);


	--
	-- Table structure for table Users
	--

	CREATE TABLE Tarkeen.Users
	(
		user_id int(128) NOT NULL,
		first_name varchar(50) NOT NULL,
		last_name varchar(50) NOT NULL,
		`password` varchar
		(250) NOT NULL,
	email varchar
		(250) NOT NULL,
	user_type_id int
		(128) NOT NULL,
        reset_token varchar(50),
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
			car_id int(128) NOT NULL
			AUTO_INCREMENT,
	car_type varchar
			(15) NOT NULL,
	car_plate varchar
			(15) NOT NULL,
	owner_id int
			(128) NOT NULL,
	PRIMARY KEY
			(car_id),
	FOREIGN KEY
			(owner_id) REFERENCES Tarkeen.Users
			(user_id),
	UNIQUE KEY `unique_car`
			(car_type, car_plate)
);


			-- --
			-- -- Table structure for table ParkingSpots
			-- --

			CREATE TABLE Tarkeen.ParkingSpots
			(
				parking_id int(128) NOT NULL
				AUTO_INCREMENT,
  zone_number varchar
				(10) NOT NULL,
  flour_number int
				(10) NOT NULL,
  parking_number int
				(10) NOT NULL,
  PRIMARY KEY
				(parking_id)
);

				-- --
				-- -- Table structure for table Reservation
				-- --

				CREATE TABLE Tarkeen.Reservation
				(
					reservation_id int(128) NOT NULL
					AUTO_INCREMENT,
	reservation_datetime datetime NOT NULL,
	extensions_count int
					(10) DEFAULT 0,
	enter_datetime datetime
					(6),
	exit_datetime datetime
					(6),
	parking_id int
					(128) NOT NULL,
	reserver_id int
					(128) NOT NULL,
	PRIMARY KEY
					(reservation_id),
	FOREIGN KEY
					(parking_id) REFERENCES Tarkeen.ParkingSpots
					(parking_id),
	FOREIGN KEY
					(reserver_id) REFERENCES Tarkeen.Users
					(user_id)
);



					--
					-- Table structure for table FeedBacks
					--

					CREATE TABLE Tarkeen.FeedBacks
					(
						feedback_id int(128) NOT NULL
						AUTO_INCREMENT,
	reservation_id int
						(128) NOT NULL,
	rating_scale int
						(8) NOT NULL,
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
  `name` varchar
							(18) NOT NULL,
  PRIMARY KEY
							(violation_type_id)
);

							-- --
							-- -- Table structure for table Violations
							-- --

							CREATE TABLE Tarkeen.Violations
							(
								violation_id int(128) NOT NULL
								AUTO_INCREMENT,
	violation_datetime datetime NOT NULL,
	car_id int
								(128) NOT NULL,
	violation_type_id int
								(128) NOT NULL,
	violator_id int
								(128) NOT NULL,
	violated_id int
								(128) NOT NULL,
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
								VALUES(1, 'KFU_MEMBER'),
									(2, 'VISITOR'),
									(3, 'SECURITY');

								--
								-- -- Users
								--

								INSERT INTO Tarkeen.Users
									(user_id, first_name, last_name, `password`, user_type_id, email
								)
		VALUES
								(11100098, 'bayan', 'ali', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 1, 'bayan@hotmail.com'),
								(220006286, 'marya', 'alsayed', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 2, 'marya@gmail.com'),
								(221009887, 'saleh', 'alsayed', '$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK', 3, 'saleh@gmail.com'),
								(220008788,'lela','alahmad','$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK',1,'lely764@gmail.com'),
								(878287269,'ali','alhaddad','$2y$10$xHXHYuJbBBZ9Tyycc9b/L.AgmJA/XPW58c9BrVmCSCcle7wiJkszK',2,'aliaalhhaddad@gmail.com ');


								--
								-- -- Cars
								--

								INSERT INTO Tarkeen.Cars
									(car_id, car_type, car_plate, owner_id)
								VALUES(1, 'jeep', '285-qas', 11100098),
									(2, 'ford', '854-mbn', 220006286),
									(3, 'ford', '874-pik', 220008788),
									(4, 'porsche', '774-qxs', 878287269);
								--
								-- --ParkingSpots 
								--
								INSERT INTO Tarkeen.ParkingSpots
									(parking_id, zone_number, flour_number, parking_number)
								VALUES(1, 'b1', 1, 2),
									(2, 'b1', 2, 3),
									(3, 'b1', 1, 4 ),
									(4, 'b1', 3, 8);
								--
								-- --Reservation
								--
								INSERT INTO Tarkeen.Reservation
									( reservation_id,reservation_datetime ,extensions_count ,enter_datetime ,
									exit_datetime , parking_id,reserver_id )
								VALUES
								(1,'2023-09-20T00:00:00', NULL,'2023-09-2T8:30:11','2023-09-20 15:30:12',1, 11100098),
								(2,'2023-09-22T00:00:00',NULL,'2023-09-22T12:30:11','2023-09-22 15:35:12',2, 220006286),
								(3,'2023-09-24T00:00:00',NULL,'2023-09-24T15:30:11','2023-09-24 16:30:12',3, 220008788),
								(4,'2023-09-25T00:00:00',NULL,'2023-09-25T9:30:11','2023-09-25 10:30:12',4, 878287269);
								--
								-- --FeedBacks
								--
								INSERT INTO Tarkeen.FeedBacks
									(feedback_id,reservation_id,rating_scale)
								VALUES
									(1, 1, 4),
									(2, 2, 5),
								(3, 3,5),
								(4 ,4,2);
								--
								-- ViolationTypes
								--

								INSERT INTO Tarkeen.ViolationTypes (violation_type_id, `name`) 
								VALUES
								(1, 'time extand'),
								(2, 'wrong parking'),
								(3, 'Exceeds the allowe');
								
								-- Violation
								--

								INSERT INTO Tarkeen.Violations
								 (violation_id,violation_datetime,car_id,violation_type_id,violator_id ,violated_id) 
	                                VALUES
									(1,'2023-09-22T00:00:00',1,1,220006286,221009887),
									(2,'2023-09-24T00:00:00',1,3,220008788,221009887),
									(3,'2023-09-25T00:00:00',2,3,220008788, 878287269);

								COMMIT;
