### Installation
- Create a database;
```
CREATE DATABASE vk_photos_and_albums;
```

- Generate a user API token following the instucrions on `https://vk.com/dev/implicit_flow_user`'

- Create `.env` file from `.env.example` and provide it with database credentials and VK token;
```
cp .env.example .env
```

- Install Composer dependencies;
```
composer install
```

- Execute `generated-sql/vk_photos_and_albums.sql` in your database;
```
mysql vk_photos_and_albums < generated-sql/vk_photos_and_albums.sql
```
