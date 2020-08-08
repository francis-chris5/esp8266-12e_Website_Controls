# esp8266-12e_Website_Controls
These are the starter files I created for IoT projects revolving around an ESP8266-12E DevBoard Microcontroller. It is still a work in progress and has only undergone rudimentary testing, these files are currently probably best used as reference material for your own projects.

Basic instructions are included in the web page itself. For the transmit files a mode of "x" will return the data in xml format, "j" will return the data in json format, "c" will return the data in csv format, and "k" is a custom string to parse through (highly recommended this be changed to fit personal needs).

It should be sufficient to upload the files to a domain hosting site, create the database, and change connectionDetails.php to reflect the names assigned by the domain host.
