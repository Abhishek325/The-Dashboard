# The Dashboard

This project is designed as a personal productivity dashboard, providing a single interface for a user to manage multiple aspects of their life and work. The system is intended to be an all-in-one environment where a user can:

- Create and manage **to-dos** and tasks
- Set up **reminders**
- Track ongoing **projects**
- Write and manage **blog posts** or notes

The project demonstrates a modular approach with separate databases for user accounts and posts, and it is built to be extended with additional productivity features over time.

## Requirements

- Docker
- Docker Compose

## Setup Instructions

1. **Clone the project**
```bash
git clone https://github.com/Abhishek325/The-Dashboard.git
cd The-Dashboard
```

2. **Start the Docker environment**
```bash
docker-compose up -d
```

This will start the PHP application and the two databases:
- mydb (users)
- mydb_posts (posts)


3. **Seed the databases**
```bash
chmod +x seed_db.sh
./seed_db.sh
```

4. **Access the project**
- Open your browser and go to, `http://localhost:8080/members/login`
- Use the pre-seeded admin account:
    - Email: admin@example.com
    - Password: admin123
