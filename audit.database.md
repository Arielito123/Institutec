# Auditoría de tablas en la base de datos Institutec

Se crearon auditorías para las siguientes tablas de la base de datos Institutec:

students
careers
teachers
subjects
internal_users
Las auditorías se crearon para registrar los siguientes eventos:

Creación de filas
Actualización de filas
Eliminación de filas
Además, se crearon tablas espejo para contener los triggers de auditoría. Estas tablas se denominan students_audit, careers_audit, etc.

# TABLA ESPEJO AUDIT_ESTUDENTS

CREATE TABLE audit_students(action VARCHAR(60),modify DATETIME,id_audit_student INT AUTO_INCREMENT PRIMARY KEY,id_estudents INT(11),name VARCHAR(45),last_name VARCHAR(45),birth_date DATETIME,direction 
VARCHAR(45),height INT(10),uk_dni INT(10),email VARCHAR(80),phone INT(12),school_year VARCHAR(4),fk_career_id INT(11),fk_id_gender INT(11));


# TRIGGER ESTUDENTS	

CREATE TRIGGER after_insert_estudents AFTER INSERT ON estudents FOR EACH ROW INSERT INTO audit_students (action, modify, id_estudents, name, last_name, birth_date, direction, height, uk_dni, email, phone, school_year, fk_career_id, fk_id_gender) VALUES ('INSERT', NOW(), NEW.id_estudents, NEW.name, NEW.last_name, NEW.birth_date, NEW.direction, NEW.height, NEW.uk_dni, NEW.email, NEW.phone, NEW.school_year, NEW.fk_career_id, NEW.fk_id_gender);



CREATE TRIGGER after_update_estudents AFTER UPDATE ON estudents FOR EACH ROW INSERT INTO audit_students (action, modify, id_estudents, name, last_name, birth_date, direction, height, uk_dni, email, phone, school_year, fk_career_id, fk_id_gender) VALUES ('Update', NOW(), NEW.id_estudents, NEW.name, NEW.last_name, NEW.birth_date, NEW.direction,NEW.height, NEW.uk_dni, NEW.email,NEW.phone, NEW.school_year, NEW.fk_career_id, NEW.fk_id_gender);
 
 
 CREATE TRIGGER after_delete_estudents AFTER DELETE ON estudents FOR EACH ROW INSERT INTO audit_students (action, modify, id_estudents, name, last_name, birth_date, direction, height, uk_dni, email, phone, school_year, fk_career_id, fk_id_gender) VALUES ('delete', NOW(), OLD.id_estudents, OLD.name, OLD.last_name, OLD.birth_date, OLD.direction,OLD.height, OLD.uk_dni, OLD.email,OLD.phone, OLD.school_year, OLD.fk_career_id, OLD.fk_id_gender);

# ----------------------------------------------------------------------------------------------------

 # TABLA ESPEJO AUDIT_TEACHERS

CREATE TABLE audit_teachers(action VARCHAR(55),modify DATETIME,id_audit_teacher INT AUTO_INCREMENT PRIMARY KEY,id_teacher INT(11),name VARCHAR(45),surname VARCHAR(45),phone INT(12),mail VARCHAR(55),direction VARCHAR(255),height int(10),dni INT(10),fk_gender_id INT(11));

# TRIGGER TEACHERS

CREATE TRIGGER after_insert_teachers AFTER INSERT ON teachers  FOR EACH ROW INSERT INTO audit_teachers(action,modify,id_teacher,name,surname,phone,mail,direction,height,dni,fk_gender_id) VALUES('insert',NOW(),NEW.id_teacher,NEW.name,NEW.surname,NEW.phone,NEW.mail,NEW.direction,NEW.height,NEW.dni,NEW.fk_gender_id)



CREATE TRIGGER after_update_teachers AFTER update ON teachers  FOR EACH ROW INSERT INTO audit_teachers(action,modify,id_teacher,name,surname,phone,mail,direction,height,dni,fk_gender_id) VALUES('update',NOW(),NEW.id_teacher,NEW.name,NEW.surname,NEW.phone,NEW.mail,NEW.direction,NEW.height,NEW.dni,NEW.fk_gender_id)


CREATE TRIGGER after_delete_teachers AFTER DELETE ON teachers  FOR EACH ROW INSERT INTO audit_teachers(action,modify,id_teacher,name,surname,phone,mail,direction,height,dni,fk_gender_id) VALUES('delete',NOW(),OLD.id_teacher,OLD.name,OLD.surname,OLD.phone,OLD.mail,OLD.direction,OLD.height,OLD.dni,OLD.fk_gender_id)

# ----------------------------------------------------------------------------------------------------

# TABLA ESPEJO INTERNAL_USER


CREATE TABLE audit_internal_user(action VARCHAR(255),modify DATETIME,id_audit_user INT AUTO_INCREMENT PRIMARY KEY,id_user INT(11),name VARCHAR(255),dni VARCHAR(255),mail VARCHAR(255),fk_rol_id INT(11));


# TRIGGER AUDIT_INTERNAL_USER

CREATE TRIGGER after_insert_internal_user AFTER INSERT ON internal_users FOR EACH ROW INSERT INTO audit_internal_user
(action,modify,id_user,name,dni,mail,fk_rol_id) VALUES ('insert',NOW(),NEW.id_user,NEW.name,NEW.dni,NEW.mail,NEW.fk_rol_id);



CREATE TRIGGER after_update_internal_user AFTER UPDATE ON internal_users FOR EACH ROW INSERT INTO audit_internal_user
(action,modify,id_user,name,dni,mail,fk_rol_id) VALUES ('update',NOW(),NEW.id_user,NEW.name,NEW.dni,NEW.mail,NEW.fk_rol_id);



CREATE TRIGGER after_delete_internal_user AFTER DELETE ON internal_users FOR EACH ROW INSERT INTO audit_internal_user
(action,modify,id_user,name,dni,mail,fk_rol_id) VALUES ('delete',NOW(),OLD.id_user,OLD.name,OLD.dni,OLD.mail,OLD.fk_rol_id);

# ----------------------------------------------------------------------------------------------------

# TABLA ESPEJO SUBJECTS

CREATE TABLE audit_subject(action VARCHAR(255),modify DATETIME,id_audit_subject INT AUTO_INCREMENT PRIMARY KEY,id_subjects INT(11),details VARCHAR(255),fk_career_id INT(11));

# TRIGGER SUBJECTS


CREATE TRIGGER after_insert_audit_subject AFTER INSERT ON subjects FOR EACH ROW INSERT INTO audit_subject
(action,modify,id_subjects,subject_name,details,fk_career_id) VALUES('insert',NOW(),NEW.id_subjects,NEW.subject_name,NEW.details,NEW.fk_career_id);



CREATE TRIGGER after_update_audit_subject AFTER UPDATE ON subjects FOR EACH ROW INSERT INTO audit_subject
(action,modify,id_subjects,subject_name,details,fk_career_id) VALUES('update',NOW(),NEW.id_subjects,NEW.subject_name,NEW.details,NEW.fk_career_id);



CREATE TRIGGER after_delete_audit_subject AFTER DELETE ON subjects FOR EACH ROW INSERT INTO audit_subject
(action,modify,id_subjects,subject_name,details,fk_career_id) VALUES('delete',NOW(),OLD.id_subjects,OLD.subject_name,OLD.details,OLD.fk_career_id);

# ----------------------------------------------------------------------------------------------------

# TABLA ESPEJO CAREERS

CREATE TABLE audit_careers(action VARCHAR(255),modify DATETIME,id_audit_career INT PRIMARY KEY,id_career INT(11),career_name VARCHAR(255),title VARCHAR(255),amount_subjects INT(255));

# TRIGGER CAREERS


CREATE TRIGGER after_insert_career
AFTER INSERT ON careers
FOR EACH ROW
INSERT INTO audit_careers (action, modify, id_career, career_name, title, amount_subjects)
VALUES ('insert', NOW(), NEW.id_career, NEW.career_name, NEW.title, NEW.amount_subjects);



CREATE TRIGGER after_update_career
AFTER UPDATE ON careers
FOR EACH ROW
INSERT INTO audit_careers (action, modify, id_career, career_name, title, amount_subjects)
VALUES ('update', NOW(), NEW.id_career, NEW.career_name, NEW.title, NEW.amount_subjects);



CREATE TRIGGER after_delete_career
AFTER DELETE ON careers
FOR EACH ROW
INSERT INTO audit_careers (action, modify, id_career, career_name, title, amount_subjects)
VALUES ('delete', NOW(), OLD.id_career, OLD.career_name, OLD.title, OLD.amount_subjects);

esto se puede hacer en phpmyadmin como dentro del contenedor, yo use phpmyadmin y la opcion sql