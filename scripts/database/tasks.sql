create table tasks(
   id INT NOT NULL AUTO_INCREMENT,
   user_id INT NOT NULL,
   description VARCHAR(100) NOT NULL,
   completed_at TIMESTAMP DEFAULT NULL,
   PRIMARY KEY ( id )
);

INSERT INTO 
    tasks (user_id, description)
VALUES 
    (1, 'This is task One'),
    (1, 'This is task Two'),
    (1, 'This is task Three'),
    (1, 'This is task Four');