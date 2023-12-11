# Automatización de la base de datos Institutec

Para automatizar la creación de copias de seguridad de la base de datos Institutec, se ha creado un script en bash. Este script se ejecuta cada tres horas, de acuerdo con la siguiente línea en el crontab:

0 */3 * * * sudo docker exec -i web bash -c "cd /var/www/html/www/Institutec && ./Script_backup.sh"
Para crear el script, siga los siguientes pasos:

Abra un editor de texto, como nano o vim.
Copie el siguiente código en el editor:
#!/bin/bash

# Crea una copia de seguridad de la base de datos Institutec

cd /var/www/html/www/Institutec

mysqldump -u root -p institutec > backup.sql
Guarde el archivo como Script_backup.sh.
Cambie los permisos del archivo para que sea ejecutable:
chmod +x Script_backup.sh
Abra el crontab con el comando sudo crontab -e.
Agregue la siguiente línea al crontab:
0 */3 * * * sudo docker exec -i web bash -c "cd /var/www/html/www/Institutec && ./Script_backup.sh"
Guarde el crontab y salga.
Una vez que haya completado estos pasos, la base de datos Institutec se respaldará automáticamente cada tres horas.
