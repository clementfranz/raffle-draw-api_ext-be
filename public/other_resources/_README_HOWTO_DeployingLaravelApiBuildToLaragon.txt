1. Turn Off ALL on Laragon first
2. Extract this and replace the folder "raffle-draw-api" inside laragon/www
3. Turn On ALL on Laragon now

4. Go to Terminal found in Laragon Window
5. Type the following commands (on each line, press enter - you can copy-paste):

php artisan migrate:fresh

php artisan tinker

\App\Models\ParticipantBatch::factory()->count(5)->create();


6. Press "Ctrl" + "C"
7. Type the following again to make API work (on each line, press enter - you can copy-paste):

php artisan route:clear

php artisan route:cache

8. Close the terminal and try using with server

