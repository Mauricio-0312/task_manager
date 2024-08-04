CREATE DATABASE gestor_tareas;

use gestor_tareas;

CREATE TABLE users(
    id int(255) auto_increment not null,
    name varchar(255),
    role varchar(255),
    surname varchar(255),
    password varchar(255),
    email varchar(255),
    created_at datetime,

    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=INNODB;

insert into users values(null, "Mauricio", "Empleado", "Fragachan", "12345678", "mauricio@mauricio.com", curtime());
insert into users values(null, "David", "Empleado", "Perez", "12345678", "david@david.com", curtime());
insert into users values(null, "Leonardo", "Empleado", "Buffet", "12345678", "leo@leo.com", curtime());


CREATE TABLE tasks(
    id int(255) auto_increment not null,
    user_id int(255) not null,
    title varchar(255),
    content text,
    priority varchar(255),
    hours int(100),
    created_at datetime,

    CONSTRAINT pk_tasks PRIMARY KEY(id),
    CONSTRAINT fk_tasks FOREIGN KEY(user_id) REFERENCES users(id)

)ENGINE=INNODB;

insert into tasks values(null, 1, "Tarea 1", "Contenido 1", "high", "19", curtime());
insert into tasks values(null, 1, "Tarea 2", "Contenido 2", "low", "13", curtime());
insert into tasks values(null, 2, "Tarea 3", "Contenido 3", "medium", "15", curtime());

/*Enable the apache pack to display the local server*/
composer require symfony/apache-pack

/*From database to entities*/

/*Generate entities from database with annotation configuration*/
php bin/console doctrine:mapping:import App\\Entity annotation --path=src/Entity

/*Generate yml configuration of the entities from database*/
php bin/console doctrine:mapping:import App\\Entity yml --path=src/Entity

/*Generate setters and getters of all entities*/
php bin/console make:entity --regenerate App

/*Generate setters and getters of one entity*/
php bin/console make:entity --regenerate App\\Entity\\entity-name

/*From entities to database*/

/*Generate entities*/
php bin/console make:entity entityName

/*Generate migration from entity in symfony*/
php bin/console doctrine:migrations:diff

/*Generate table on database from entity in symfony*/
php bin/console doctrine:migrations:migrate

//

/*Execute queries on the console*/
php bin/console doctrine:query:sql "statement"

/**/
composer require doctrine maker