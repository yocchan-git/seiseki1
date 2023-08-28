create database seiseki1;

create table tests
(
    id int not null,
    year int not null,
    name varchar(32) not null,
    create_at date,
    updated_at timestamp,
    primary key(id)
);

create table students
(
    id int not null,
    year int not null,
    class varchar(20) not null,
    number int not null,
    name varchar(32) not null,
    create_at date,
    updated_at timestamp,
    primary key(id)
);

create table exams
(
    id int not null,
    test_id int not null,
    student_id int not null,
    kokugo int not null,
    sugaku int not null,
    eigo int not null,
    rika int not null,
    shakai int not null,
    goukei int not null,
    create_at date,
    updated_at timestamp,
    primary key(id)
);