## Installation ⚒️

Installing and running Power Maintenance is super easy, please follow below steps and you will be ready to rock 🤘

1. Open the terminal in your root directory of Power Maintenance Laravel.
2. Make sure your php version not less 8.0.2.
3. Use following command to install composer

```bash
composer install
```

3. Run the following command to generate the key

```bash
php artisan key:generate
```

4. By running the following command, you will be able to get all the dependencies in your **node_modules** folder:

```bash
npm install
```

5. To run the project, you need to run following command in the project directory. It will compile JavaScript and Styles.

```bash
npm run dev
```

6. To run the project, you need to run following command in the project directory. It will migrate database table and seed.

```bash
php artisan migrate:refresh --seed 
```

7. To serve the application, you need to run the following command in the project directory

```bash
php artisan serve
```

8. Now navigate to the given address, you will see your application is running.🥳

Login Credentials
```
Email : admin@gmail.com
Password : 12345678
```
