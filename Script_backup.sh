#!/bin/bash

# Variables de entorno para configurar la copia de seguridad
SQL_SERVER="db"
MYSQL_ROOT_PASSWORD="hola1234"
DB_NAME="institutec"
BACKUP_DIR="backup"  # Ruta relativa proporcionada

# Verifica si el directorio de respaldo existe, si no, créalo
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
    echo "Carpeta de respaldo creada: $BACKUP_DIR"
fi

# Nombre del archivo de copia de seguridad con guiones entre la fecha, mes y hora
BACKUP_FILE="$BACKUP_DIR/Respaldo_$(date +\%Y-\%m-\%d_\%H-\%M-\%S).sql"

# Comando de respaldo para MySQL (especificando el servidor y el puerto)
mysqldump -h "$SQL_SERVER" -P 3306 -u"root" -p"$MYSQL_ROOT_PASSWORD" "$DB_NAME" > "$BACKUP_FILE"

# Verifica si el respaldo fue exitoso
if [ $? -eq 0 ]; then
    # Cambia los permisos del archivo de respaldo
    chmod 777 "$BACKUP_FILE"
    echo "Copia de seguridad exitosa. Archivo: $BACKUP_FILE"
else
    echo "Error en la copia de seguridad. Verifica las credenciales y la disponibilidad del servidor MySQL."
fi

