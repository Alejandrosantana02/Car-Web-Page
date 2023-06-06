CREATE TABLE car (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    name          VARCHAR(1000),
    time          VARCHAR(1000),
    horsepower    VARCHAR(1000),
    year          YEAR,
    price         VARCHAR(1000),
    photo         VARCHAR(1000),
    description   VARCHAR(1000),
    UNIQUE (name)
);


CREATE TABLE users (
    id            INT PRIMARY KEY AUTO_INCREMENT,
    email         TEXT NOT NULL,
    password      TEXT NOT NULL,
    is_active     BOOLEAN NOT NULL,
    is_admin      BOOLEAN NOT NULL
);

CREATE TABLE comments (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    body        VARCHAR(10000),
    date        DATETIME,
    user_id     INT,
    context_id  INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (context_id) REFERENCES car(id)
);
