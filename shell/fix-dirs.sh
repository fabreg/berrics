#!/bin/sh

dir_magic() {

        if [ -d "$1" ]; then

                rm -rf  "$1";    
                echo "DELETING $1";
        fi

        mkdir "$1";

        #chnage the owner
        chmod -R 777 "$1";

        chown -R theberrics:theberrics "$1";

}

$(dir_magic "../admin.theberrics.com/public_html/app/tmp/cache");
$(dir_magic "../admin.theberrics.com/public_html/app/tmp/cache/models");
$(dir_magic "../admin.theberrics.com/public_html/app/tmp/cache/persistent");

$(dir_magic "../theberrics.com/public_html/app/tmp/cache");
$(dir_magic "../theberrics.com/public_html/app/tmp/cache/models");
$(dir_magic "../theberrics.com/public_html/app/tmp/cache/persistent");

