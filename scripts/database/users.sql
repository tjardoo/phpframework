create table users(
   id INT NOT NULL AUTO_INCREMENT,
   email VARCHAR(100) NOT NULL,
   first_name VARCHAR(50) NOT NULL,
   last_name VARCHAR(50) NOT NULL,
   is_active INT(2) DEFAULT FALSE,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY ( id )
);

INSERT INTO 
    users (email, first_name, last_name, is_active)
VALUES 
    ('demo1@example.org', 'Demo', 'One', 1),
    ('demo2@example.org', 'Demo', 'Two', 0),
    ('demo3@example.org', 'Demo', 'Three', 1),
    ('demo4@example.org', 'Demo', 'Four', 0);