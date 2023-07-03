# The News
## Project Structure

The News project follows a standard structure recommended by the Laravel framework for backend application and React structure for frontend application. Below is an overview of the main directories and files:

## Project Structure
- **backend/**: Backend laravel project.
- **frontend/**: Backend react project.
- **docker/**: Project docker files.
- **docker-compose.yml/**: File containing dockerization setup of all docker containers.

## Backend Structure
- **app/**: Contains the core application code, including controllers, models, and other PHP classes.
- **config/**: Contains configuration files for various aspects of the application, such as database connections and service providers.
- **database/**: Contains database-related files, including migrations and seeders.
- **public/**: The public directory is the document root for your application. It contains the entry point (`index.php`) and assets such as CSS and JavaScript files.
- **resources/**: Contains views, language files, and other resource files used by the application.
- **routes/**: Contains the route definitions for the application.
- **storage/**: Contains application storage, including logs, cache, and uploaded files.
- **tests/**: Contains test cases for the application.
- **vendor/**: Contains dependencies installed via Composer.

## Fronend Structure
- **public/**: Contains the HTML template and other static assets for the application.
- **src/**: Contains the main source code of the React application.
  - **assets/**: Contains style sheets and images (static content).
  - **app/**: Contains all the project app components.
    - **api/**: Contains all the api call functions.
    - **components/**: Contains reusable UI components.
    - **constants/**: Contains all the constants used through out the app.
    - **helpers/**: Contains modules for handling API requests or other external services.
    - **layouts/**: Contains all the app layouts.
    - **pages/**: Contains components representing different pages or routes of the application.
    - **redux/**: Contains redux store related action and reducers.
    - **routes/**: Contains all the app internal screen routes.
    - **utils/**: Contains utility functions or helper modules.
  - **App.js**: The root component of the application.
  - **index.js**: The entry point of the application, responsible for rendering the App component and mounting it in the DOM.
- **.gitignore**: Specifies files and directories to be ignored by Git.
- **package.json**: Contains metadata and dependencies for the project.
- **README.md**: This readme file.

## Docker Structure
- **backend/**: Backend dockerization related files.
- **frontend/**: Frontend dockerization related files.
- **db/**: Database dockerization related files.
- **nginx/**: Nginx dockerization related files.

# Getting Started

### Prerequisites

Make sure you have the following tools installed on your system:

- Docker
- Docker Compose

### Env files (Backend)
<details>
  <summary><code>.env Files</code></summary>
  ## Usage

  1. Go to backend directory and Rename `.env.example` to `.env`.
  2. Open the `.env` file in a text editor.
  3. Modify the values of the environment variables to match your specific configuration.

**Note**: Ensure that sensitive information, such as API tokens and passwords, are properly secured and not exposed in version control.

</details>

### Env files (Frontend)
<details>
  <summary><code>.env Files</code></summary>
  ## Usage

  1. Go to frontend directory and Create `.env` file.
  2. Place following env variables there

- REACT_APP_API_END_POINT="http://127.0.0.1:8000/api/v1"

**Note**: Ensure that sensitive information, such as API tokens and passwords, are properly secured and not exposed in version control.

</details>

### Installation

1. Clone the project repository to your local machine:

2. Navigate to the project root directory:

3. Run command "docker-compose build"

This command will download the necessary Docker images and build the containers defined in the `docker-compose.yml` file.

## Running the Project

To run the project using Docker Compose, use the following command: "docker-compose up"

This command will start the containers and run the Laravel and React application. You can access the application in your web browser by visiting:

- **backend/**: `http://localhost:8000`.
- **frontend/**: `http://localhost:3000`.

To stop the running containers, press `Ctrl+C` in the terminal.


## Swagger docs
To get the swagger documentation of all the backend apis, Use this url
- **backend-swagger-url/**: `http://localhost:8000/api/documentation`.

## Project demo
<details>
  <summary><code>Video</code></summary>

  To see a demonstration of the project in action, you can watch the following video:

  [![Project Demo](https://drive.google.com/file/d/1HY5Q272b5i4ovJdBWOmGVoowPYXV4_Wl/view?usp=sharing)](https://drive.google.com/file/d/1HY5Q272b5i4ovJdBWOmGVoowPYXV4_Wl/view?usp=sharing)
  

</details>

<details>
  <summary><code>Image</code></summary>

  Here is an image showcasing a swagger ui of project:

  ![Project Image](https://drive.google.com/file/d/18G2Dh2aDNTDDN4rgpQpXdFM3cn7H-xuj/view?usp=sharing)

  Link: https://drive.google.com/file/d/18G2Dh2aDNTDDN4rgpQpXdFM3cn7H-xuj/view?usp=sharing

</details>

## Article sources used
- NewsOrg/
- TheGuardian/
- NewYorkTimes/

## Project cron command note
<details>
  <summary><strong>Note</strong></summary>
  
  On setting up project and running with "docker-compose up", backend cron command will fetch all the news articles from the sources. After that cron command will run every day at 13:00.

</details>