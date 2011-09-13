#!/bin/sh

#sync WEB1
rsync -vaz --delete /home/sites/berrics.dev/admin.theberrics.com/public_html/ /home/sites/berrics/admin.theberrics.com/public_html/
## shared folders
### sharedModels
rsync -vaz --delete /home/sites/berrics.dev/sharedModels/ /home/sites/berrics/sharedModels/
### sharedVendors
rsync -vaz --delete /home/sites/berrics.dev/sharedVendors/ /home/sites/berrics/sharedVendors/
### sharedPlugins
rsync -vaz --delete /home/sites/berrics.dev/sharedPlugins/ /home/sites/berrics/sharedPlugins/
### Shared Controllers
rsync -vaz --delete /home/sites/berrics.dev/sharedControllers/ /home/sites/berrics/sharedController/

## WEB2


