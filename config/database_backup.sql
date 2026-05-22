/*CREATE TABLE users(
    id           SERIAL PRIMARY KEY NOT NULL,
    firstname    VARCHAR(50)  NOT NULL,
    lastname     VARCHAR(50)  NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    psswd        TEXT         NOT NULL,
    mobile_phone VARCHAR(20)  NOT NULL UNIQUE,
    address      VARCHAR(100) NULL,
    birthday     DATE         NULL,
    status       BOOLEAN      DEFAULT TRUE,
    gender       CHAR(1)      DEFAULT NULL,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    deleted_at   TIMESTAMP    DEFAULT NULL
);*/

CREATE TABLE users(
    id           SERIAL PRIMARY KEY NOT NULL,
    firstname    VARCHAR(50)  NOT NULL,
    lastname     VARCHAR(50)  NOT NULL,
    email        VARCHAR(100) NOT NULL UNIQUE,
    psswd        TEXT         NOT NULL,
    mobile_phone VARCHAR(20)  NOT NULL UNIQUE,
    address      VARCHAR(100) NULL,
    birthday     DATE         NULL,
    status       BOOLEAN      DEFAULT TRUE,
    gender       CHAR(1)      DEFAULT NULL,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    deleted_at   TIMESTAMP    DEFAULT NULL
);

--list_users.php
alter table users
	add column url_photo text;

SELECT 
    u.firstname || ' ' || u.lastname AS fullname,
	u.email,
	u.mobile_phone

	CASE
		WHEN u.status=true the 'Active' else 'Inactive' END as status,
	u.profile_photo
    FROM
        users u
FROM users;

update users set url_photo='profile_photos/user_default.png';


create table customers(
	id int primary key not null,
	name varchar(100),
	email varchar(150),
	phone varchar(20),
	address varchar(255),
	created_at timestamp default now(),
	updated_at timestamp default now(),
	deleted_at timestamp null
);

create table brands(
	id int primary key not null,
	name varchar(100),
	country varchar(100),
	created_at timestamp default now(),
	updated_at timestamp default now(),
	deleted_at timestamp null
);

create table vehicles(
	id int primary key not null,
	brand_id int,
	model varchar(100),
	year int,
	price decimal(12,2),
	stock int,
	color varchar(30),
	created_at timestamp default now(),
	updated_at timestamp default now(),
	deleted_at timestamp null,
	CONSTRAINT fk_brand FOREIGN KEY (brand_id) REFERENCES brands(id)
);

create table sales(
	id int primary key not null,
	user_id int,
	vehicle_id int,
	sale_date date,
	total_amount decimal(12,2),
	status varchar(20),
	created_at timestamp default now(),
	updated_at timestamp default now(),
	deleted_at timestamp null,
	CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id),
	CONSTRAINT fk_vehicle FOREIGN KEY (vehicle_id) REFERENCES vehicles(id)
);

create table payments(
	id int primary key not null,
	sale_id int,
	customer_id int,
	payment_method varchar(50),
	amount decimal(12,2),
	payment_date date,
	created_at timestamp default now(),
	updated_at timestamp default now(),
	deleted_at timestamp null,
	CONSTRAINT fk_sale FOREIGN KEY (sale_id) REFERENCES sales(id),
	CONSTRAINT fk_customer FOREIGN KEY (customer_id) REFERENCES customers(id)
);

alter table users
add role varchar(50);