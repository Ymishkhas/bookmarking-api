CREATE TABLE IF NOT EXISTS bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    clicks_count INT NOT NULL,
    date_added DATETIME NOT NULL
);

INSERT INTO bookmarks(title, user_id, url, clicks_count, date_added) VALUES ('React.js', '1', 'https://react.dev', 0, NOW());
INSERT INTO bookmarks(title, user_id, url, clicks_count, date_added) VALUES ('Docker', '1', 'https://docker.com', 0, NOW());
INSERT INTO bookmarks(title, user_id, url, clicks_count, date_added) VALUES ('GitHub', '1', 'https://github.com', 0, NOW());