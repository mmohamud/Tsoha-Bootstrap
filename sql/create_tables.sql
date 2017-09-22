-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja (
id SERIAL PRIMARY KEY,
Kayttajatunnus varchar (50) NOT NULL,
Nimi varchar (100) NOT NULL,
Salasana varchar (50) NOT NULL
);

CREATE TABLE Kategoria(
id SERIAL PRIMARY KEY,
Nimi varchar (50)
);

CREATE TABLE Aanestys(
id SERIAL PRIMARY KEY,
Kategoria_id INTEGER REFERENCES Kategoria(id),
Nimi varchar (50) NOT NULL,
Kuvaus varchar (400) NOT NULL,
Kaynnissa boolean,
Yksityinen boolean DEFAULT FALSE,
Alkamispaiva DATE,
Sulkeutumispaiva DATE
);


CREATE TABLE Aani(
Kayttaja_id INTEGER REFERENCES Kayttaja(id),
Aanestys_id INTEGER REFERENCES Aanestys(id)
);

