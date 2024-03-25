ALTER TABLE album ADD COLUMN user_email varchar(100);
UPDATE album SET user_email='john@example.com' WHERE title='In My Dreams';
UPDATE album SET user_email='john@example.com' WHERE title='21';
