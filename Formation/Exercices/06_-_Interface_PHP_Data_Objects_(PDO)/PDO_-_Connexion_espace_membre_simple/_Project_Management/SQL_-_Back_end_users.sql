#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: capability
#------------------------------------------------------------

CREATE TABLE capability(
        id  Int NOT NULL ,
        lbl Varchar (50) NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: role
#------------------------------------------------------------

CREATE TABLE role(
        id    Int NOT NULL ,
        lbl   Varchar (50) NOT NULL ,
        power Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: user
#------------------------------------------------------------

CREATE TABLE user(
        id        Int NOT NULL ,
        login     Varchar (50) NOT NULL ,
        pwd       Varchar (50) NOT NULL ,
        lastname  Varchar (100) NOT NULL ,
        firstname Varchar (100) NOT NULL ,
        id_role   Int NOT NULL ,
        PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: rel_role_capability
#------------------------------------------------------------

CREATE TABLE rel_role_capability(
        id            Int NOT NULL ,
        id_capability Int NOT NULL ,
        PRIMARY KEY (id ,id_capability )
)ENGINE=InnoDB;

ALTER TABLE user ADD CONSTRAINT FK_user_id_role FOREIGN KEY (id_role) REFERENCES role(id);
ALTER TABLE rel_role_capability ADD CONSTRAINT FK_rel_role_capability_id FOREIGN KEY (id) REFERENCES role(id);
ALTER TABLE rel_role_capability ADD CONSTRAINT FK_rel_role_capability_id_capability FOREIGN KEY (id_capability) REFERENCES capability(id);
