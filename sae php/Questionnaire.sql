drop table choixQuestions;
drop table score;
drop table questions;
drop table questionnaires;
drop table utilisateurs;

CREATE TABLE utilisateurs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  role ENUM('createur', 'repondeur') NOT NULL
);

CREATE TABLE questionnaires (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  utilisateur_id INT NOT NULL,
  FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  questionnaire_id INT NOT NULL,
  type ENUM('texte', 'choix multiple', 'vrai ou faux','numerique') NOT NULL,
  texte VARCHAR(255) NOT NULL,
  FOREIGN KEY (questionnaire_id) REFERENCES questionnaires(id) ON DELETE CASCADE
);

CREATE TABLE choixQuestions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question_id INT NOT NULL,
  choix VARCHAR(255) NOT NULL,
  juste BOOLEAN NOT NULL,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

CREATE TABLE score(
  utilisateur_id INT NOT NULL,
  questionnaire_id INT NOT NULL,
  points INT NOT NULL,
  FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
  FOREIGN KEY (questionnaire_id) REFERENCES questionnaires(id) ON DELETE CASCADE
);

INSERT INTO utilisateurs VALUES(1,"Admin","admin","createur");
INSERT INTO questionnaires VALUES(1,"QuestionnaireAdmin",1);
INSERT INTO questionnaires VALUES(2,"QuestionnaireAdmin2",1);
INSERT INTO questions VALUES(1,1,"texte","Quel pays a gagné la coupe du monde de football de 2022 ?");
INSERT INTO choixQuestions VALUES(80,1,"Argentine", TRUE);
INSERT INTO questions VALUES(2,1,"choix multiple","Qui est le meilleur joueur du monde ?");
INSERT INTO choixQuestions VALUES(1,2,"Ronaldo", TRUE);
INSERT INTO choixQuestions VALUES(2,2,"Messi", FALSE);
INSERT INTO choixQuestions VALUES(3,2,"Mbappe", FALSE);
INSERT INTO choixQuestions VALUES(4,2,"Neymar", FALSE);
INSERT INTO questions VALUES(3,1,"vrai ou faux","Cette question est vrai");
INSERT INTO choixQuestions VALUES(5,3,"VRAI",TRUE);

INSERT INTO questions VALUES(10,2,"texte","Quel pays a gagné la coupe du monde de football de 2022 ?");
INSERT INTO choixQuestions VALUES(10,10,"Argentine", TRUE);
INSERT INTO questions VALUES(11,2,"choix multiple","Quel est le pire jeu ?");
INSERT INTO choixQuestions VALUES(11,11,"Valorant", FALSE);
INSERT INTO choixQuestions VALUES(12,11,"League of legends", TRUE);
INSERT INTO choixQuestions VALUES(13,11,"Fortnite", FALSE);
INSERT INTO choixQuestions VALUES(14,11,"Rocket League", FALSE);
INSERT INTO questions VALUES(12,2,"vrai ou faux","Est ce que la Karmine Corp est finito en LFL (la honte) ?");
INSERT INTO choixQuestions VALUES(15,12,"VRAI", TRUE);
INSERT INTO questions VALUES(13,2,"vrai ou faux","Est ce que la Karmine Corp va gagner la LFL cette année ?");
INSERT INTO choixQuestions VALUES(16,13,"FAUX", TRUE);