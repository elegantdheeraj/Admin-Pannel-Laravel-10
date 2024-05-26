# Admin Panel with User Management, Access & Permissions

## Overview
This project is an Admin Panel that provides comprehensive user management, access control, and permissions. It allows administrators to manage users, roles, and permissions effectively, ensuring secure and organized access to different parts of the system.

## Features
- **User Management:** Add, edit, delete, and view users.
- **Role Management:** Create and manage roles with specific permissions.
- **Access Control:** Restrict access to various sections of the application based on user roles and permissions.
- **Authentication:** Secure login and logout functionality.
- **Dashboard:** Overview of system statistics and user activities.

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

2. Configure environment variables

3. **Run the following :**
    1) Run the migration using following cmd
   ```sh
   php artisan migrate
   ```
    2) Run the seeding using following cmd
   ```sh
   php artisan db:seed
   ```
    Note: These command run in docker container php-8 for this you need to run command
   ```sh
   sudo docker exec -it php-8 bash
   ```
    and goto mart directory. Now you can run above command.
4. **Access the application:**
    Open your browser and navigate to `http://localhost:8004`.

## Usage

### Creating Roles
1. Navigate to the Users -> Role Permissions section in the admin panel.
2. Click on "Add Role" and fill in the necessary details.
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
- Thanks to the contributors and the open-source community for their valuable inputs and support.

## Contact
For any questions or suggestions, please contact us at [elegant.dheeraj@gmail.com].

