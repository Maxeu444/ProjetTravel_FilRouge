USE travel_project;

INSERT INTO airport (code, name, city, country, gate_count)
VALUES 
('LAX', 'Los Angeles International Airport', 'Los Angeles', 'USA', 9),
('JFK', 'John F. Kennedy International Airport', 'New York', 'USA', 6),
('LHR', 'London Heathrow Airport', 'London', 'UK', 5),
('CDG', 'Charles de Gaulle Airport', 'Paris', 'France', 4),
('HND', 'Tokyo International Airport', 'Tokyo', 'Japan', 3),
('SYD', 'Sydney Kingsford Smith Airport', 'Sydney', 'Australia', 4);

-- INSERT INTO user (username, password, firstname, lastname, email, creation_date)
-- VALUES 
-- ('john_doe', 'mypassword', 'John', 'Doe', 'john.doe@example.com', NOW()),
-- ('jane_doe', 'mypassword', 'Jane', 'Doe', 'jane.doe@example.com', NOW());

INSERT INTO plane (capacity, model, isAvailable, airport_id)
VALUES 
(100, 'Boeing 737',1, 1),
(150, 'Airbus A320',1, 2),
(300, 'Boeing 777',0, 3),
(250, 'Airbus A330',0, 4),
(200, 'Boeing 787', 1,5),
(180, 'Airbus A350', 1,6);

INSERT INTO flight (number, price, airline, departure_datetime, arrival_datetime, departure_airport, arrival_airport, plane_id)
VALUES 
('AA100', 50, 'American Airlines', '2023-06-10 10:00:00', '2023-06-10 14:00:00', 1, 2, 1),
('DL200', 100, 'Delta Airlines', '2023-06-12 13:30:00', '2023-06-12 17:30:00', 2, 3, 2),
('BA300', 20, 'British Airways', '2023-06-15 16:00:00', '2023-06-15 20:00:00', 3, 4, 3),
('AF400', 80, 'Air France', '2023-06-18 08:00:00', '2023-06-18 12:00:00', 4, 5, 4),
('JL500', 200, 'Japan Airlines', '2023-06-20 09:45:00', '2023-06-20 13:45:00', 5, 6, 5),
('QF600', 170, 'Qantas Airways', '2023-06-22 11:15:00', '2023-06-22 15:15:00', 6, 1, 6);

-- INSERT INTO booking (date, price, seat_number, flt_id, acc_id)
-- VALUES 
-- (NOW(), '200', 23, 1, 1),
-- (NOW(), '400', 10, 2, 2),
-- (NOW(), '300', 15, 3, 2),
-- (NOW(), '250', 12, 4, 1),
-- (NOW(), '500', 5, 5, 1);