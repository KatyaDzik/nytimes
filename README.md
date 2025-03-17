# Docker Setup Guide

## Prerequisites
Ensure you have the following installed:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Step 1: Configure Environment Variables
1. Copy the example environment file to the root directory:
   ```sh
   cp .env.example .env
   ```
2. Update the `.env` file with your own values:
   ```ini
   UID=1000
   GID=1000
   ```

## Step 2: Start Docker Containers
Run the following command to start the containers:
```sh
docker-compose up -d
```

## Step 3: Configure Application Environment Variables
1. Copy the example environment file inside the `src` folder:
   ```sh
   cp src/.env.example src/.env
   ```
2. Update the `src/.env` file with your API key:
   ```ini
   NYT_API_KEY=your_api_key_here
   NYT_BASE_URL="https://api.nytimes.com/svc/books/v3/lists/best-sellers/history.json"
   ```
   > **Note:** Keep `NYT_BASE_URL` as the default value.

### How to Obtain `NYT_API_KEY`
1. Create a New York Times developer account: [Sign Up](https://developer.nytimes.com/accounts/create)
2. Go to [Create a New App](https://developer.nytimes.com/my-apps/new-app)
3. Enable the **Books API**
4. Create your app
5. Copy your API key locally

## Step 4: Install Dependencies
Once the containers are running, install the project dependencies:
```sh
docker exec nyt_app composer install
```

## Step 5: Generate Laravel Application Key
Run the following command to generate the application key:
```sh
docker exec nyt_app php artisan key:generate
```

## Application is Ready 🎉
You can now access the API at:
```
http://localhost:8000/api/best-sellers
```

## Running Tests
To execute the test suite, run:
```sh
docker exec nyt_app php artisan test --testsuite=Feature
```

