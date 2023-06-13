# Let's-Do-It PHP Site

## Description

Let's-Do-It is a PHP-based web application that provides a comprehensive task management system with authentication features. It allows users to create personal tasks, collaborate on group tasks, and provides an admin section for managing user groups and tasks. The application utilizes MySQL as the database backend and is dockerized using Docker Compose for easy deployment.

## Features

### Authentication

The Let's-Do-It site incorporates a robust authentication system. Users can register their accounts and securely log in to access the application's features. The authentication ensures that only authorized users can interact with the system.

### Personal Task Section

Once authenticated, users have access to their personal task section. Here, they can create, update, and delete tasks according to their requirements. The personal task section provides a dedicated space for managing individual tasks and helps users stay organized.

### Group User Admin Section

The Let's-Do-It site includes a group user admin section, which is specifically designed for administrators or privileged users. In this section, admins can manage user groups, add or remove members, assign roles, and handle other user-related tasks. The group user admin section ensures efficient management of user accounts within the application.

### Group Tasks Section

Collaboration is a vital aspect of task management, and the Let's-Do-It site recognizes this need. The group tasks section enables users to create and manage tasks that are shared among a specific group. Users belonging to the group can view, edit, and mark tasks as complete, fostering effective teamwork and task coordination.

## Technology Stack

The Let's-Do-It PHP site leverages the following technologies:

- **PHP**: The core programming language used to build the application.

- **MySQL**: The relational database system used to store user data, tasks, and other related information.

- **Docker Compose**: The containerization tool used to package the application and its dependencies into portable and reproducible Docker containers.

## Laravel Framework

During the development process of Let's-Do-It, it became evident that using a PHP framework such as Laravel could have significantly facilitated the development and optimization of the site. Laravel is a powerful framework that provides a wealth of features and tools specifically designed for web application development. It offers benefits such as increased productivity, simplified routing, built-in security features, and robust database abstraction. Implementing Laravel would have made the development process smoother, more efficient, and enjoyable.

However, for the purposes of this project, the Let's-Do-It site was developed without utilizing Laravel or any other PHP framework, allowing for a more hands-on learning experience and a deeper understanding of the underlying technologies.

## Installation and Deployment

To deploy the Let's-Do-It PHP site using Docker Compose, follow these steps:

1\. Clone the project repository to your local machine.

2\. Ensure you have Docker and Docker Compose installed.

3\. Open a terminal and navigate to the project directory `cd letz-do-it/prod`.

4\. Run the command `docker-compose up -d` to start the Docker containers in detached mode.

5\. Run the command `chmod 777 letz-do-it/prod/images`

6\. Wait for the containers to be built and started. Once completed, the Let's-Do-It site should be accessible at the specified port.

Note: Before running the project, ensure that the necessary configuration files and environment variables are correctly set up, including the MySQL database credentials.

## Conclusion

Let's-Do-It is a PHP-based task management site that incorporates authentication, personal task management, group user administration, and group task collaboration features. Although the development process highlighted the potential benefits of using a framework like Laravel, the project was built without one to provide a more in-depth understanding of the underlying technologies. The site is dockerized using Docker Compose, making it easy to deploy
