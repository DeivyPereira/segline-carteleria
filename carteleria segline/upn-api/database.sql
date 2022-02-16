CREATE TABLE users (
	id int primary key auto_increment,
    uuid varchar(36),
    name varchar(255),
    email varchar(255),
    password varchar(255),
    role varchar(50),
    status int,
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

INSERT INTO users (uuid, name, email, password, role, status, created, modified, deleted) VALUES ("c52a744d-d198-4b21-bbe1-5f3d915670d0", "John Doe", "admin@mail.com", "$2y$10$HgvGAWNtZ/J79RetzX0x/.YZdWg57xuV9yzo.qpU7yfvWaoYhgmSi", 1, 1, "2020-02-05 09:33:42", "2020-02-05 09:33:42", 0);

CREATE TABLE tv (
	id int primary key auto_increment,
    uuid varchar(36),
    name varchar(255),
    description varchar(255),
    sede varchar(255),
    status int,
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

CREATE TABLE multimedia (
	id int primary key auto_increment,
    uuid varchar(36),
	name varchar(255),
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

CREATE TABLE render (
	id int primary key auto_increment,
    uuid varchar(36),
    title varchar(255),
    type int,
    start varchar(255),
    end varchar(255),
    sede varchar(255),
    tv_uuid varchar(36), 
    border int,
    status int,
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

CREATE TABLE render_drops(
	id int primary key auto_increment,
    uuid varchar(36),
    render_uuid varchar(36),
    name varchar(255),
	grid int,
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

CREATE TABLE render_demo(
	id int primary key auto_increment,
    uuid varchar(36),
    data varchar(500),
	created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

CREATE TABLE schedule(
	id int primary key auto_increment,
    uuid varchar(36),
    month varchar(10),
    year varchar(10),
    sede int,
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);

CREATE TABLE schedule_tasks(
id int primary key auto_increment,
    uuid varchar(36),
    schedule_uuid varchar(36),
    title varchar(255),
    date varchar(255),
    description varchar(255),
    created varchar(255),
    modified varchar(255),
    deleted varchar(255)
);