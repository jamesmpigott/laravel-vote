# Laravel Voting System

## Requirements
- PHP 8.1 or greater
- Node 14.17.0 or greater

## Setup

 1. Install server-side dependencies `composer install`.
 2. Install client-side dependencies `npm install`.
 3. Add `NOTIFICATION_EMAIL` to your `.env` file.
 4. run `php artisan key:generate`
 5. Run `php artisan migrate`.
 6. Run `php artisan vote:add-poll` and follow the prompts ***or*** run `php artisan db:seed --class=PollSeeder`.
 7. Once the above command has been completed, the URL for your poll will be provided.

### Things that need work
- Email templates should look better
- IP Geolocation functionality has not been built. 
