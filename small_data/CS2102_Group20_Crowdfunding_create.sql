-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2016-09-09 10:13:39.416

-- tables
-- Table: category
CREATE TABLE category (
    id int NOT NULL,
    name varchar(30) NOT NULL,
    CONSTRAINT category_pk PRIMARY KEY (id)
);

-- Table: donation
CREATE TABLE donation (
    id bigint NOT NULL,
    user_id int NOT NULL,
    project_id int NOT NULL,
    message varchar(255) NOT NULL,
    amount double NOT NULL,
    created timestamp NOT NULL,
    CONSTRAINT donation_pk PRIMARY KEY (id)
);

-- Table: project
CREATE TABLE project (
    id int NOT NULL,
    title varchar(80) NOT NULL,
    description text NOT NULL,
    goal double NOT NULL,
    start_date date NOT NULL,
    duration int NOT NULL,
    owner_id int NOT NULL,
    CONSTRAINT project_pk PRIMARY KEY (id)
);

-- Table: project_category
CREATE TABLE project_category (
    project_id int NOT NULL,
    category_id int NOT NULL,
    CONSTRAINT project_category_pk PRIMARY KEY (project_id,category_id)
);

-- Table: session
CREATE TABLE session (
    id int NOT NULL,
    user_id int NOT NULL,
    CONSTRAINT session_pk PRIMARY KEY (id)
) COMMENT 'set life span';

-- Table: user
CREATE TABLE user (
    id int NOT NULL,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    is_admin bool NOT NULL,
    UNIQUE INDEX email (email),
    CONSTRAINT user_pk PRIMARY KEY (id)
);

-- views
-- View: category_numProject
CREATE VIEW category_numProject AS
SELECT category_id, COUNT(*) AS numPorject FROM project_category GROUP BY category_id;

-- foreign keys
-- Reference: category_project_category (table: project_category)
ALTER TABLE project_category ADD CONSTRAINT category_project_category FOREIGN KEY category_project_category (category_id)
    REFERENCES category (id);

-- Reference: product_category_product (table: project_category)
ALTER TABLE project_category ADD CONSTRAINT product_category_product FOREIGN KEY product_category_product (category_id)
    REFERENCES project (id);

-- Reference: project_supporter (table: donation)
ALTER TABLE donation ADD CONSTRAINT project_supporter FOREIGN KEY project_supporter (project_id)
    REFERENCES project (id);

-- Reference: user_Session (table: session)
ALTER TABLE session ADD CONSTRAINT user_Session FOREIGN KEY user_Session (user_id)
    REFERENCES user (id);

-- Reference: user_project (table: project)
ALTER TABLE project ADD CONSTRAINT user_project FOREIGN KEY user_project (owner_id)
    REFERENCES user (id);

-- Reference: user_supporter (table: donation)
ALTER TABLE donation ADD CONSTRAINT user_supporter FOREIGN KEY user_supporter (user_id)
    REFERENCES user (id);

-- End of file.

