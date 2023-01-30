# Lead Management System

Lead maangement is a web-based system that is written in php, the system consist of currently hosted in digital ocean with ubuntu 22.10 being the main os of the machine and apache as the web-server and mysql for the database server. This is the documentation of the deployment of the system and all the things that are installed

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

# Importing the database and deploying the system
