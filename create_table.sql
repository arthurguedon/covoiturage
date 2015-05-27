# -------------------------------------------------------------------------------------------------------
# Instruction pour créer la table ou seront stockée les information des utilisateur inscrit sur le site 
# --------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS utilisateur ( 
 
nom VARCHAR(45) NOT NULL, 
prenom VARCHAR(45) NOT NULL, 
annee_naissance INTEGER NOT NULL, 

id VARCHAR(45) NOT NULL, 
mdp VARCHAR(45) NOT NULL, # deux utilisateur different peuvent avoir le meme
image VARCHAR(45) NOT NULL,  

cagnote INTEGER NOT NULL, 
id_voiture INTEGER,

PRIMARY KEY(id) 
# FOREIGN KEY (id_voiture) REFERENCES TO voiture(id_voiture)
#    ON DELETE CASCADE
#    ON UPDATE RESTRICT 

);


# -------------------------------------------------------------------------------------------------------
# Instruction pour créer la table ou seront stockée les voitures
# --------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS voiture ( 
 
marque VARCHAR(45) NOT NULL, 
couleur VARCHAR(45) NOT NULL,
annee_mise_en_fonction INTEGER NOT NULL, 
nb_place_max INTEGER NOT NULL,

id_voiture INTEGER NOT NULL AUTO_INCREMENT, 
id_conducteur VARCHAR(45) NOT NULL, 

PRIMARY KEY(id_voiture)
 
# FOREIGN KEY (id_conducteur) REFERENCES TO utilisateur(id)
    # ON DELETE CASCADE
    # ON UPDATE RESTRICT
);


# -------------------------------------------------------------------------------------------------------
# Instruction pour créer la table ou seront stockée les appreciations
# --------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS appreciation ( 

commentaire VARCHAR(150), # un utilisateur peut simplement laisser une note sans commentaire
note INTEGER NOT NULL, # chiffre qui sera afficher sous forme de mot pour les utilisateurs 

id_destinataire VARCHAR(45) NOT NULL,
id_expediteur VARCHAR(45) NOT NULL,

date VARCHAR(45) NOT NULL,
heure VARCHAR(45) NOT NULL

# FOREIGN KEY (id_destinataire) REFERENCES TO utilisateur(id)
    # ON DELETE CASCADE
    # ON UPDATE RESTRICT
);


# -------------------------------------------------------------------------------------------------------
# Instruction pour créer la table ou seront stockée les messages
# --------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS message ( 

commentaire VARCHAR(150), # un utilisateur peut simplement laisser une note sans commentaire

id_destinataire VARCHAR(45) NOT NULL,
id_expediteur VARCHAR(45) NOT NULL,

date VARCHAR(45) NOT NULL,
heure VARCHAR(45) NOT NULL

# FOREIGN KEY (id_destinataire) REFERENCES TO utilisateur(id)
#    ON DELETE CASCADE
#    ON UPDATE RESTRICT
);



# -------------------------------------------------------------------------------------------------------
# Instruction pour créer la table ou seront stockée les trajets
# --------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS trajet ( 

id_trajet INTEGER NOT NULL AUTO_INCREMENT,
id_conducteur VARCHAR(45) NOT NULL,

ville_depart VARCHAR(45) NOT NULL,
ville_arrivee VARCHAR(45) NOT NULL,
        
date DATE NOT NULL,
heure VARCHAR(45) NOT NULL,

prix INTEGER NOT NULL,
nb_place INTEGER NOT NULL,

# effectue BOOLEAN NOT NULL,

PRIMARY KEY(id_trajet) 

# FOREIGN KEY (id_conducteur) REFERENCES TO utilisateur(id)
#    ON DELETE CASCADE
#    ON UPDATE RESTRICT,
);


# -------------------------------------------------------------------------------------------------------
# Instruction pour créer la table ou seront stockée les passagers
# --------------------------------------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS passager ( 


id_trajet INTEGER NOT NULL,
id_passager VARCHAR(45) NOT NULL


# FOREIGN KEY (id_passager) REFERENCES TO utilisateur(id)
#    ON DELETE CASCADE
#    ON UPDATE RESTRICT,

# FOREIGN KEY (id_trajet) REFERENCES TO trajet(id_trajet)
#    ON DELETE CASCADE
#    ON UPDATE RESTRICT

);


ALTER TABLE utilisateur ADD CONSTRAINT idVoitureU FOREIGN KEY (id_voiture) REFERENCES voiture(id_voiture)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;

ALTER TABLE voiture ADD CONSTRAINT idVoitureV FOREIGN KEY (id_conducteur) REFERENCES utilisateur(id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;

ALTER TABLE appreciation ADD CONSTRAINT idAppreciation FOREIGN KEY (id_destinataire) REFERENCES utilisateur(id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;

ALTER TABLE message ADD CONSTRAINT idMessage FOREIGN KEY (id_destinataire) REFERENCES utilisateur(id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;

ALTER TABLE passager ADD CONSTRAINT idPassagerU FOREIGN KEY (id_passager) REFERENCES utilisateur(id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;

ALTER TABLE passager ADD CONSTRAINT idPassagerT FOREIGN KEY (id_trajet) REFERENCES trajet(id_trajet)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;

ALTER TABLE trajet ADD CONSTRAINT idTrajet FOREIGN KEY (id_conducteur) REFERENCES utilisateur(id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT ;