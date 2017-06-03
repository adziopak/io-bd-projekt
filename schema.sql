SET foreign_key_checks = 0;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS buildings;
DROP TABLE IF EXISTS maps;
DROP TABLE IF EXISTS paths;
DROP TABLE IF EXISTS pins;
SET foreign_key_checks = 1;

CREATE TABLE admins (
    id              INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_name       VARCHAR2(45) NOT NULL,
    user_password   VARCHAR2(61) NOT NULL,
    last_visit      DATE
);

CREATE TABLE buildings (
    id         INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name       VARCHAR2(45) NOT NULL,
    lat        FLOAT NOT NULL,
    lon        FLOAT NOT NULL,
    admin_id   INTEGER NOT NULL
);

CREATE TABLE maps (
    id             INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    floor          INTEGER NOT NULL,
    image          VARCHAR2(45) NOT NULL,
    image_md5      VARCHAR2(33) NOT NULL,
    image_width    INTEGER NOT NULL,
    image_height   INTEGER NOT NULL,
    building_id    INTEGER NOT NULL,
    admin_id       INTEGER NOT NULL
);

CREATE TABLE paths (
    id              INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_pin_id    INTEGER NOT NULL,
    second_pin_id   INTEGER NOT NULL,
    admin_id        INTEGER NOT NULL
);

CREATE TABLE pins (
    id         INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name       VARCHAR2(45),
    pos_x      FLOAT NOT NULL,
    pos_y      FLOAT NOT NULL,
    map_id     INTEGER NOT NULL,
    admin_id   INTEGER NOT NULL
);

ALTER TABLE buildings ADD CONSTRAINT buildings_admins_fk FOREIGN KEY ( admin_id )
    REFERENCES admins ( id );

ALTER TABLE maps ADD CONSTRAINT maps_admins_fk FOREIGN KEY ( admin_id )
    REFERENCES admins ( id );

ALTER TABLE maps ADD CONSTRAINT maps_buildings_fk FOREIGN KEY ( building_id )
    REFERENCES buildings ( id );

ALTER TABLE paths ADD CONSTRAINT paths_admins_fk FOREIGN KEY ( admin_id )
    REFERENCES admins ( id );

ALTER TABLE paths ADD CONSTRAINT paths_pins_fk FOREIGN KEY ( first_pin_id )
    REFERENCES pins ( id );

ALTER TABLE paths ADD CONSTRAINT paths_pins_fkv2 FOREIGN KEY ( second_pin_id )
    REFERENCES pins ( id );

ALTER TABLE pins ADD CONSTRAINT pins_admins_fk FOREIGN KEY ( admin_id )
    REFERENCES admins ( id );

ALTER TABLE pins ADD CONSTRAINT pins_maps_fk FOREIGN KEY ( map_id )
    REFERENCES maps ( id );