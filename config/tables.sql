CREATE TABLE `forms` (
 
 `id` int(11) NOT NULL PRIMARY KEY auto_increment,
 
 `fname` varchar(250) NOT NULL,
 
 `lname` varchar(250) NOT NULL,
 
 `email` varchar(250) NOT NULL,
 
 `age` int NOT NULL,
 
 `smoker` bool NOT NULL,
 
 `zip` varchar(250) NOT NULL,
 
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 
 `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;