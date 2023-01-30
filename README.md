# Lead Management System

Lead maangement is a web-based system that is written in php, the system is currently hosted in digital ocean with ubuntu 22.10 being the main os of the machine and apache as the web-server and mysql for the database server. This is the documentation of the deployment of the system and all the things that are installed

# Host Creation for the deployment of the system
To begin, you must create a droplet on digital ocean.
```Choose Region: Singapore
   Choose Image: Ubuntu v22.10
   Droplet Type: Basic
   CPU options: Regular
   2GB / 1CPU
   60GB SSD Disk
   2TB Transfer
   Authentication Method: password
   Machine IP: 128.199.103.165
```
The list above are the current configuration of the machine that will host the system.

# Remote Access via CLI
To access the server remotely, connect to it via ssh and use ```usethisPassword_1here``` for the authentication method.

# GUI Access
For the GUI access of the machine, the machine is equipped with xrdp for remote access, the following step will walk through the installation of xrdp

Install xrdp

```
sudo apt install xrdp
```

Once installed, enable xrdp to start on boot by running: systemctl command will add xrdp to the list of application that ubuntu automatically start upon boot.
```
sudo systemctl enable xrdp
```

Lastly, set ufw firewall to accept tcp connection on port 3389
```
sudo ufw allow 3389/tcp
```

In this machine, ubuntu desktop is the display server. To install display server, issue the command:
```
sudo apt-get install ubuntu-desktop
```

After installing ubuntu desktop, create a user that is not root. To create a user, issue the command:
```
adduser your_new_username
```
the username on this machine is ```leadhost``` as user and password being ```leadpassword```

# Installation and Configuration of MySQL and Apache2 server
First, install MySQL server, issue the following command:

```
sudo apt install mysql-sever
```
After the installation of mysql server, configure mysql credentials
```mysql
use mysql
select user, plugin, host FROM mysql.user;
ALTER USER 'root'@'localhost' IDENTIFIED WITH caching_sha2_password BY 'newpassword';
FLUSH PRIVILEGES;
```
'newpassword' shall be replace by the desired password, the password of the mysql installed in this machine is ```root```

After configuring the server, install phpmyadmin. To install, issue the command below:
```
sudo apt install phpmyadmin
```

Upon installation of phpmyadmin, it will prompt to install a web server ```apache2``` is the server that is used to deploy this project.

After the installation, accessing phpmyadmin can be done in two ways, via localhost which using the xrdp remote or through any browser
```
   Browser access: 128.199.103.165/phpmyadmin/
   localhost access: localhost/phpmyadmin/
```
The credentials of the mysql server in the machine is ```root``` being the username and password

# Deployment of the system and importing the database
To be able to deploy the project, it must be download from the github repo and must be placed on the machine. The repo link will be paste below.
```
https://github.com/akkibet/leadmanagement
```
After downloading, the project file must be placed under the directory of the apache server. To move the file from downloads directory to apache2 server directory, issue the following command:
```
sudo mv /home/leadhostDownloads/lms/* /var/www/html
```
After moving the file, configuration settings of the project must be edit. The file that needs to be edit are ```initialize.php``` and ```DBConnection.php``` under ```/var/www/html/classes```
Under ```initialize.php``` the line that needs to be change is:
```
From
if(!defined('base_url')) define('base_url','http://localhost/lms/');
To
if(!defined('base_url')) define('base_url','../');
```
Since we will be accessing the website outside it's localhost, it must be fetch from parent directory otherwise the url will turn to localhost.
Under ```DBConnection.php``` certain changes must be made:
```
    private $host = "localhost";
    private $username = "root";
    private $password = "root";
    private $database = "lms_db";
```
If the system will be host on other platform, this settings must be change such as the username and the password. But on this machine, the machine is configured in a same way it is configured in the localhost environment. Therefore configuration can be leave as it's default configuration.
After that, the database of the project must be import at the sql server of the host. The database file is located at:
```
/var/www/html/database/
```
# Domain Configuration
Up to this point, the website is fully functional and can be access outside the localhost. However, leaving the ip expose and not giving it a domain name is a huge security threat of the system. Therefore it is assinged with a domain.
Noip.com is the domain provider of the domain used in this system.
After setting up a domain on noip domain provider, it must be configured on digital ocean. For that, you must create a droplet for dns.
After Setting up a droplet, you must enter the domain name that the noip provide, and direct it to the machine where the website is hosted.
