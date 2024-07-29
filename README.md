# MotherLink
## 3 Steps Media Database Import

* This mini project is a response to the task.

## Criteria
* Tech stack:
    * Please use Laravel jobs for importing the file and sockets for making import summary

* Features:
    * The modal screen displays the media database template, which the user can
         download and fill out with his data.
    * Import validation should be considered (Media, publisher & email is
         mandatory)
    * Category validation should be considered, Categories to proceed with import validation (1 per row):
      * Arts, Culture and Events
      * Auto and Moto
      * Beauty, Cosmetics, Pharmaceuticals
      * Economy, Business and Banking
      * Food and Gastronomy

* Actions
  * Chose file - The user can either drag and drop the file into the designated area or
    manually select it by clicking the link.
  * Next - The system uploads the file, analyzes it, and then presents the import
    summary for the user to review.
  * Back - The user returns to the step #1.
  * Close (X icon) - The system closes the dialog and stops the uploading process if a file
    has been selected.

## Instructions and installation

* Clone repo
* From your console at your root folder execute 'composer install' to install dependencies. 
Project uses  [Laravel Excel](https://docs.laravel-excel.com/3.1/getting-started/installation.html) library, if you have problem installing it please see documentation.
* At your project root, rename '.env.example' file to '.env' and set DB connection.
* From your console at your root folder execute 'php artisan key:generate' to generate and set APP_KEY.
* From your console at your root folder execute 'sh checkall.sh' to start migrations and seeders.
* To run the app, from your console at your root folder execute 'php artisan serve' and click on the link.

Enjoy :) 
