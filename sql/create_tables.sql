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
Sulkeutumispaiva DATE
);


CREATE TABLE Vaihtoehto(
id SERIAL PRIMARY KEY,
Aanestys_id INTEGER REFERENCES Aanestys(id),
Vaihtoehto varchar (100) NOT NULL
);


CREATE TABLE Aani(
id SERIAL PRIMARY KEY,
Kayttaja_id INTEGER REFERENCES Kayttaja(id),
Vaihtoehto_id INTEGER REFERENCES Vaihtoehto(id)
);



