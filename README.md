<h1>Setup & Development</h1>

This my test task for Genion, it is a Laravel-based web application using MySQL (local server), Vite, and Tailwind CSS.

Requirements
PHP 8.1+
Composer
Node.js + npm
MySQL (local server)

<h1>Installing</h1>
<pre>
git clone https://github.com/zsoltp2/genion_test_task.git 
cd genion
composer install
npm install 
cp .env.example .env 
php artisan key:migrate
</pre>


Update your .env file with your MySQL credentials:
<pre>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=genion_test
DB_USERNAME=root
DB_PASSWORD=

</pre>


Run migrations
<pre>
php artisan migrate
</pre>

Then start the development servers:
<pre>
php artisan serve
npm run dev
</pre>

Important: You must run <strong>npm run dev</strong> for the styling to work properly via Vite.

<h1>
    First User Login
</h1>
After registering the first user, you need to manually activate them in the database for login to work. Make the changes directly in the database (localhost/phpmyadmin) or run the following SQL command:

<pre>
UPDATE users SET is_admin = 1, is_accepted_request = 1 WHERE id = 1;
</pre>

<strong>If you followed these steps, you can start making accounts, accepting them with your admin account and send friend requests!</strong>
