# Web minecraftd
Web interface for minecraftd script

### Install minecraftd
 * link: https://aur.archlinux.org/packages/minecraft-server/
 * move minecraftd.sh script to `/usr/local/bin/minecraftd`
 * move minecraftd.conf file to `/etc/conf.d/minecraft`
 * create system group minecraft (`groupadd -r minecraft`)
 * create system user minecraft (`useradd -r -g minecraft -d /srv/minecraft minecraft`)
 * (optional) move minecraftd.service to `/usr/lib/systemd/system/minecraftd.service`
 * download minecraft_server.jar and move it to `/srv/minecraft/minecraft_server.jar`

### Install Web Interface
 * move `minecraftd` folder to webroot
 * add line to sudoers file (`sudo visudo`) : `www-data ALL=(minecraft) NOPASSWD: ALL` (some systems use different user for apache ex. 'http')
