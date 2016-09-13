-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2016-09-09 11:17:08.326

-- tables
-- Table: account
CREATE TABLE account (
    id int  NOT NULL,
    name varchar(255)  NOT NULL,
    email varchar(255)  NOT NULL,
    password varchar(255)  NOT NULL,
    is_admin bool  NOT NULL,
    CONSTRAINT email UNIQUE (email) NOT DEFERRABLE  INITIALLY IMMEDIATE,
    CONSTRAINT account_pk PRIMARY KEY (id)
);

-- Table: category
CREATE TABLE category (
    id int  NOT NULL,
    name varchar(30)  NOT NULL,
    CONSTRAINT category_pk PRIMARY KEY (id)
);

-- Table: donation
CREATE TABLE donation (
    id bigint  NOT NULL,
    user_id int  NOT NULL,
    project_id int  NOT NULL,
    message text  NOT NULL,
    amount decimal  NOT NULL,
    created timestamp  NOT NULL,
    CONSTRAINT donation_pk PRIMARY KEY (id)
);

-- Table: project
CREATE TABLE project (
    id int  NOT NULL,
    title varchar(80)  NOT NULL,
    description text  NOT NULL,
    goal decimal  NOT NULL,
    start_date date  NOT NULL,
    duration int  NOT NULL,
    owner_id int  NOT NULL,
    CONSTRAINT project_pk PRIMARY KEY (id)
);

-- Table: project_category
CREATE TABLE project_category (
    project_id int  NOT NULL,
    category_id int  NOT NULL,
    CONSTRAINT project_category_pk PRIMARY KEY (project_id,category_id)
);

-- Table: session
CREATE TABLE session (
    id int  NOT NULL,
    user_id int  NOT NULL,
    CONSTRAINT session_pk PRIMARY KEY (id)
);

-- views
-- View: category_numProject
CREATE VIEW category_numProject AS
SELECT category_id, COUNT(*) AS numPorject FROM project_category GROUP BY category_id;

-- foreign keys
-- Reference: category_project_category (table: project_category)
ALTER TABLE project_category ADD CONSTRAINT category_project_category
    FOREIGN KEY (category_id)
    REFERENCES category (id)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: product_category_product (table: project_category)
ALTER TABLE project_category ADD CONSTRAINT product_category_product
    FOREIGN KEY (category_id)
    REFERENCES project (id)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: project_supporter (table: donation)
ALTER TABLE donation ADD CONSTRAINT project_supporter
    FOREIGN KEY (project_id)
    REFERENCES project (id)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: user_Session (table: session)
ALTER TABLE session ADD CONSTRAINT user_Session
    FOREIGN KEY (user_id)
    REFERENCES account (id)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: user_project (table: project)
ALTER TABLE project ADD CONSTRAINT user_project
    FOREIGN KEY (owner_id)
    REFERENCES account (id)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- Reference: user_supporter (table: donation)
ALTER TABLE donation ADD CONSTRAINT user_supporter
    FOREIGN KEY (user_id)
    REFERENCES account (id)  
    NOT DEFERRABLE 
    INITIALLY IMMEDIATE
;

-- End of file.

