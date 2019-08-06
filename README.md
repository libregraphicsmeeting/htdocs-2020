# libregraphicsmeeting.org/2020

Grav based website for the LGM 2020

## Local setup

To get Grav to serve the LGM pages on your computer you need to first download the Grav zip package and then add the files from the LGM Git repository.

You can then start the php development server to see the result (at the time of writing, you'll need a patch for Grav to serve the files).

Here are the details:

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

At the end of this process you should have a structure that is similar to:

```
lgm-2020/
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
                quark-lgm-2020/
    sync/
```

## Publishing the local files

Currently, we do not plan to have a web UI for the website.

You can simply create the file in your local Grav, add them to the Git repository and when you push them, the file will be deployed to the website (through a webhook on Github and a trivial `git update` script on the web server).

## Todo

- We will have to check how to define the users and store them in git (or have different users in the local instance and online)
