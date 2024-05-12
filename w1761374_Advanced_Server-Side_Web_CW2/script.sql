create table answer
(
    id       int auto_increment
        primary key,
    uid      int  not null,
    question int  not null,
    time     text not null,
    answer   text not null
);

create table `like`
(
    id       int auto_increment
        primary key,
    uid      int                  not null,
    question int                  null,
    answer   int                  null,
    `like`   tinyint(1) default 1 not null,
    time     text                 not null
);

create table question
(
    id       int auto_increment
        primary key,
    question text not null,
    time     text not null,
    tags     text not null,
    uid      int  not null
);

create table user
(
    id         int auto_increment
        primary key,
    first_name text         not null,
    last_name  text         not null,
    username   varchar(300) null,
    email      varchar(300) null,
    password   text         not null,
    constraint email
        unique (email),
    constraint username
        unique (username)
);


