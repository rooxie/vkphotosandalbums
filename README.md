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

- Run installation file
```
php install.php
```

- Execute `generated-sql/vk_photos_and_albums.sql` in your database;
```
mysql vk_photos_and_albums < generated-sql/vk_photos_and_albums.sql
```

### Usage

Import users from Vk

```
php vk fetch-users <user-id>,<user-id>
```

Import photos from Vk

```
php vk fetch-photos <user-id>
```

Import albums from Vk

```
php vk fetch-albums <user-id>
```

Get users from the database

```
php vk get-users <user-id>,<user-id>
```


