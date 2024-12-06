CREATE TABLE IF NOT EXISTS bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    date_added DATETIME NOT NULL
);

INSERT INTO bookmarks(title, url, date_added) VALUES ('React.js', 'https://react.dev', NOW());
INSERT INTO bookmarks(title, url, date_added) VALUES ('Docker', 'https://docker.com', NOW());
INSERT INTO bookmarks(title, url, date_added) VALUES ('GitHub', 'https://github.com', NOW());