#!/bin/bash
# Seed databases inside their respective containers

# Users database
echo "Seeding users database..."
docker cp mydb.sql mariadb:/tmp/mydump.sql
docker exec -i mariadb sh -c 'mysql -u user -puserpassword mydb < /tmp/mydump.sql'

# Posts database
echo "Seeding posts database..."
docker cp mydb_posts.sql mariadb_posts:/tmp/mydump.sql
docker exec -i mariadb_posts sh -c 'mysql -u user2 -puserpassword mydb_posts < /tmp/mydump.sql'

echo "Seeding complete!"
