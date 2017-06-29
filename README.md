### Installation
- Install Composer dependencies.
```
composer install
```

- Generate a user API token following the instucrions on `https://vk.com/dev/implicit_flow_user`.

- Create `.env` file.

On Unix
```
cp .env.example .env
```

On Windows
```
copy .env.example .env
```

- Provide VK API token and MySQL credentials to `.env` file.
