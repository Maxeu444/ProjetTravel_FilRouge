CREATE DATABASE travel_project;

USE travel_project;

CREATE TABLE airport (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    gate_count INT NOT NULL
);

CREATE TABLE user (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
	roles VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR (255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    creation_date DATETIME NOT NULL
);

CREATE TABLE plane (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    capacity INT NOT NULL,
    model VARCHAR(255) NOT NULL,
    isAvailable BIT NOT NULL DEFAULT 1,
    airport_id INT NOT NULL,
    CONSTRAINT fk_plane_airport
        FOREIGN KEY(airport_id)
        REFERENCES airport(id)
        ON DELETE CASCADE
);

CREATE TABLE flight (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    number VARCHAR(255) UNIQUE NOT NULL,
    price INT NOT NULL DEFAULT 0,
    airline VARCHAR(255) NOT NULL,
    departure_datetime DATETIME NOT NULL,
    arrival_datetime DATETIME NOT NULL,
    departure_airport INT NOT NULL,
    arrival_airport INT NOT NULL,
    plane_id INT NOT NULL,
    CONSTRAINT fk_flight_dep_airport
        FOREIGN KEY(departure_airport)
        REFERENCES airport(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_flight_arr_airport
        FOREIGN KEY(arrival_airport)
        REFERENCES airport(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_flight_plane
        FOREIGN KEY(plane_id)
        REFERENCES plane(id)
        ON DELETE CASCADE
);

CREATE TABLE booking (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    date DATETIME NOT NULL,
    seat_number INT NOT NULL,
    flight_id INT NOT NULL,
    user_id INT NOT NULL,
    CONSTRAINT fk_booking_flight
        FOREIGN KEY(flight_id)
        REFERENCES flight(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_booking_user
        FOREIGN KEY(user_id)
        REFERENCES user(id)
        ON DELETE CASCADE
);

CREATE TABLE history (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    number VARCHAR(255) UNIQUE NOT NULL,
    airline VARCHAR(255) NOT NULL,
    departure_datetime DATETIME NOT NULL,
    arrival_datetime DATETIME NOT NULL,
    departure_airport INT NOT NULL,
    arrival_airport INT NOT NULL,
    plane_id INT NOT NULL,
    CONSTRAINT fk_flight_dep_airport
        FOREIGN KEY(departure_airport)
        REFERENCES airport(id),
        ON DELETE CASCADE
    CONSTRAINT fk_flight_arr_airport
        FOREIGN KEY(arrival_airport)
        REFERENCES airport(id),
        ON DELETE CASCADE
    CONSTRAINT fk_flight_plane
        FOREIGN KEY(plane_id)
        REFERENCES plane(id)
        ON DELETE CASCADE

    date DATETIME NOT NULL,
    price INT NOT NULL,
    seat_number INT NOT NULL,
    -- colonnes user plutôt que clé étrangère ?
    user_id INT NOT NULL,
    CONSTRAINT fk_booking_user
        FOREIGN KEY(user_id)
        REFERENCES user(id)
        ON DELETE CASCADE
)