
-- ##################################### PRIVATE LEARNING GUIDE #####################################
-- A) The DEFAULT constraint provides a default value for a column.
--      The default value will be added to all new records if no other value is specified.
--      The DEFAULT constraint can also be used to insert system values, by using functions like GETDATE():
-- B) Using FOREIGN KEY, references a table's row to another table's row. 
--      This causes the the referenced table's attempt to delete a row to fail, unless no rows in other tables refer to it
-- ##################################################################################################



-- ##################################### HELP #####################################
-- 1) Database is mysql
-- 2) if ($_SERVER["REQUEST_METHOD"] == "POST") is better than if (isset($_POST["submit"])) 
--      * because $_POST["submit"] can be set even if submit button not clicked.
-- 2) $_SERVER["PHP_SELF"] - used to get current file path
--      * however, vulnerable to "cross site script (xss)" attacks. recommeneded to filter ->
--          example: <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
--          according to online research, it is useful when using routes and contollers,
--          however, people recommended to handle form submits in another file, and redirect back, due to f5 refresh resubmit issue
-- 3) simplest way to add env variables is to use a .env file, however that requires setting up a composer

-- ################################################################################



-- Create Users table
CREATE TABLE Users (
    id int NOT NULL AUTO_INCREMENT,
    full_name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    age int NOT NULL,
    phone_number varchar(255),
    created_at datetime NOT NULL DEFAULT NOW(),
    updated_at datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    PRIMARY KEY (id),
    UNIQUE (email)
);

-- Create Forums table
CREATE TABLE Forums (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (title)
);

-- Create Posts table
CREATE TABLE Posts (
    id int NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    content text NOT NULL,
    forum_id int NOT NULL,
    poster_email varchar(255) NOT NULL,
    created_at datetime NOT NULL DEFAULT NOW(),
    updated_at datetime NOT NULL DEFAULT NOW() ON UPDATE NOW(),
    PRIMARY KEY (id),
    FOREIGN KEY (poster_email) REFERENCES Users(email)
);