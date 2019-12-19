# nanoblog
PHP project for MSSE Web Development Class. Final Nano-site project.
Set up LAMP for your device.

## Create Database

```
mysql -u root -p
CREATE USER 'nanobloguser'@'localhost' IDENTIFIED BY 'nanobloguserpwd';
CREATE DATABASE nanoblog;
GRANT SELECT ON nanoblog.* TO 'nanobloguser'@'localhost';
GRANT CREATE ON nanoblog.* TO 'nanobloguser'@'localhost';
GRANT UPDATE ON nanoblog.* TO 'nanobloguser'@'localhost';
GRANT DELETE ON nanoblog.* TO 'nanobloguser'@'localhost';
\q
```

## Load data to database
Navigate to project files.

`mysql -u root -p nanoblog < nanoblogexport.sql`
