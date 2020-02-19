# Swiftea Website

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/e9b0b1b1cbbf4bfdb51ca94ba5602d1a)](https://app.codacy.com/app/hugo-posnic/Web?utm_source=github.com&utm_medium=referral&utm_content=Swiftea/Web&utm_campaign=Badge_Grade_Dashboard)

## Deploy

        cd /www/Web
        git pull

## Reset

Here is describe how to reset evrything: database and inverted index.

 - Go in phpmyadmin and empty the website database.
 - Connect ssh, then:


    cd www/swiftea-server/app/worker
    rm -R data


License
-------

GNU GENERAL PUBLIC LICENSE (v3)

**Free Software, Hell Yeah!**
