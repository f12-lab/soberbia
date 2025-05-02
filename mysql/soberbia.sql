USE soberbia;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', '$2y$10$zZTnD/hTbYbTtqdm5Gz5heNdk3ZT1/tdB9lXIXr5bVyyJXbSgq1yy');
INSERT INTO users (username, password) VALUES ('test', '$2y$10$JWoqQ7f1P6MOxkXlWQksF4STkR.4w9TFlOMpCkd.1Yr9H8hewh7.G');

CREATE TABLE coments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    comentario TEXT NOT NULL
);