# Admin Panel with User Management, Access & Permissions

## Overview
This project is an Admin Panel that provides comprehensive user management, access control, and permissions. It allows administrators to manage users, roles, and permissions effectively, ensuring secure and organized access to different parts of the system.

## Features
- **User Management:** Add, edit, delete, and view users.
- **Role Management:** Create and manage roles with specific permissions.
- **Access Control:** Restrict access to various sections of the application based on user roles and permissions.
- **Authentication:** Secure login and logout functionality.
- **Dashboard:** Overview of statistics.

## Technologies Used
- **Frontend:**
  - HTML5
  - CSS3
  - JavaScript (ES6+)
  - Framework (jQuery, Bootstrap5)
- **Backend:**
  - PHP (Laravel 10)
  - Database (MySQL 8)
- **Authentication:**
  - Basic

## Installation

### Prerequisites
- Docker
- Dokcer-compose 

### Steps
1. **Clone the repository:**
    ```sh
    git clone https://github.com/elegantdheeraj/mart.git
    cd Admin-Pannel-Laravel-10
    ```
2. **create Docker envirnment:** After cloning goto the Admin-Pannel-Laravel-10 directory and run the docker cmd.
   ```sh
   sudo docker-compose up -d
   ```
3. Configure environment variables
   ```sh
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=adminPannelLaravel10
    DB_USERNAME=root
    DB_PASSWORD=php123
   ```
   ##### Note: For creating a database you need to make a connection using the following config which is in the docker-compose.yml as
   ```sh
   hostname: localhost
   port:3312
   username:root
   password:php123
   ```
3. **Run the following:**
    1) Run the migration using the following cmd
   ```sh
   php artisan migrate
   ```
    2) Run the seeding using the following cmd
   ```sh
   php artisan db:seed
   ```
    Note: These commands run in the docker container php-8 for this you need to run the command
   ```sh
   sudo docker exec -it php-8 bash
   ```
    and go to the mart directory. Now you can go ahead and run the above command.
4. **Access the application:**
    Open your browser and navigate to `http://localhost:8004`.

## Usage

### Creating Roles
1. Navigate to the admin panel's Users -> Role Permissions section.
2. Click "Add Role" and fill in the necessary details.
3. Assign permissions to the role.

### Managing Users
1. Navigate to the Users -> Lists section.
2. Click on "Add User" to create a new user.
3. Edit or delete users as needed.
4. Assign roles to users to manage their access levels.


## Contributing
We welcome contributions to improve this project. Please follow these steps:
1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Commit your changes (`git commit -m 'Add new feature'`).
4. Push to the branch (`git push origin feature-branch`).
5. Open a Pull Request.

## Acknowledgments
- Thanks to the contributors and the open-source community for their valuable input and support.

## Contact
For any questions or suggestions, please contact us at [elegant.dheeraj@gmail.com].

