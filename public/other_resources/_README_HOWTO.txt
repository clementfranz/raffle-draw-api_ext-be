1. Go to MySQL Table 'participants'
2. Go to "Import" Tab
3. Do not upload yet, go to "Format" section first
4. Choose the "CSV" format
5. Then go below, on the "Format-specific options:"
6. Remove values for input box of "Columns enclosed with:" and "Columns escaped with:"
7. On the input box "Column names:", paste the following:

id_entry,full_name,raffle_code,regional_location,registered_at

8. Upload the File using the "File to import:" section
9. On the "Other Options", disable the switch for "Enable foreign key checks"
10. Hit "Import" button at the bottom of the page


Compatibility Check:

Database server
Server: localhost via TCP/IP
Server type: MySQL
Server version: 8.0.30 - MySQL Community Server - GPL
Protocol version: 10
Server charset: UTF-8 Unicode (utf8mb4)

Web server
Apache/2.4.63 (Win64) OpenSSL/3.0.15 PHP/8.3.21
Database client version: libmysql - mysqlnd 8.3.21
PHP extension: mysqli Documentation curl Documentation mbstring Documentation
PHP version: 8.3.21

phpMyAdmin
Version information: 5.2.0, latest stable version: 5.2.2