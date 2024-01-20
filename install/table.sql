CREATE TABLE question(
    uuid VARCHAR(250),
    label TEXT,
    correct VARCHAR(100),
    type VARCHAR(10),
    PRIMARY KEY (uuid)
);

CREATE TABLE choix(
    uuid VARCHAR(250),
    label TEXT,
    PRIMARY KEY (uuid, label)
);