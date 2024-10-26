# User Authentication System

This project implements a user authentication system with signup and login functionalities. Users can register with their details including a profile image, and then log in with their credentials.

## Features

- **User Signup**: Register with first name, last name, email, password, and profile image.
- **User Login**: Log in with email and password.
- **Profile Image Upload**: Users can upload a profile image during signup.

## File Structure

. ├── api.php ├── classes/ │ └── Database.php ├── includes/ │ ├── login.php │ ├── signup.php ├── style.css ├── uploads/ │ └── default.png └── index.html


## Setup

### Database

Create a MySQL database and use the following SQL to create the users table:

```sql
CREATE TABLE user (
    userid VARCHAR(20) PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    //profile_image VARCHAR(255) DEFAULT 'default.png', // hto yet implemented
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
