ALTER TABLE users
ADD birthdate DATE NULL;

ALTER TABLE users
ADD role ENUM('Student', 'Faculty') NOT NULL DEFAULT 'Student';