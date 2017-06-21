# Web minecraftd
Web interface for minecraftd script

### Installation
 * move `minecraftd` to a folder in webroot
 * copy minecraftd script to `/usr/local/bin/minecraftd`
 * copy minecraftd.conf file to `/etc/conf.d/minecraft`
 * create system group minecraft (`groupadd -r minecraft`)
 * create system user minecraft (`useradd -r -g minecraft -d /srv/minecraft minecraft`)
 * add line to sudoers file (`sudo visudo`) : `www-data ALL=(minecraft) ALL` (some systems use different user for apache ex. 'http')

