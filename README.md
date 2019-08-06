# libregraphicsmeeting.org/2020

Grav based website for the LGM 2020

## Local install

The file tree will be as following:

```
.htaccess
grav/
    users/
        accounts/
        config/
        data/
        pages/
            ...
        plugins/
            error/
            markdown-notices/
            problems/
        themes/
            quark/
            quark-lgm-2019/
sync/
```

- Create a new directory that will contain the website: that will be the the website directory.
- Download Grav and put the zip file in the website directory
- Unzip it (you should know have a `grav` directory in the website directory).
- Delete the `grav/user/pages` directory with its content.
- in `grav/user/config/` delete all files but 
  - `security.yaml` (if it exists)
- Get the project files from git:
  - Make sure you're at the root of the the website directory (the one containing the `grav` directory)
  - `git init`
  - `git remote add origin https://github.com/libregraphicsmeeting/htdocs-2020.git`
  - `git fetch origin`
  - `git checkout --track origin/master`
- Apply [the patch for running grav in its own directory](https://github.com/getgrav/grav/pull/2541):
  - `cd grav`
  - `wget https://patch-diff.githubusercontent.com/raw/getgrav/grav/pull/2541.diff`
  - `git apply 2541`
- Start the php development web server at the root of the website directory (or setup Apache to serve the site):  
  `GRAV_BASEDIR="/grav" php -S localhost:8000 grav/system/router.php`
- Go to `localhost:8000` with a browser.

## Todo

- We will have to check how to define the users and store them in git (or have different users in the local instance and online)
