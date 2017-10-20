-- Lisää CREATE TABLE lauseet tähän tiedostoon
CREATE TABLE Kayttaja (
id SERIAL PRIMARY KEY,
Kayttajatunnus varchar (50),
Nimi varchar (100) NOT NULL,
Salasana varchar (50) NOT NULL,
Admin boolean
);


CREATE TABLE Kategoria(
id SERIAL PRIMARY KEY,
Nimi varchar (50)
);

CREATE TABLE Aanestys(
id SERIAL PRIMARY KEY,
Kategoria_id SERIAL REFERENCES Kategoria(id) ON DELETE CASCADE,
Kayttaja_id SERIAL REFERENCES Kayttaja(id) ON DELETE CASCADE,
Nimi varchar (50) NOT NULL,
Kuvaus varchar (400) NOT NULL,
Kaynnissa boolean,
Sulkeutumispaiva DATE
);


CREATE TABLE Vaihtoehto(
id SERIAL PRIMARY KEY,
Aanestys_id SERIAL REFERENCES Aanestys(id) ON DELETE CASCADE,
Vaihtoehto varchar (100) NOT NULL
);


CREATE TABLE Aani(
id SERIAL PRIMARY KEY,
Kayttaja_id SERIAL REFERENCES Kayttaja(id) ON DELETE CASCADE,
Vaihtoehto_id SERIAL REFERENCES Vaihtoehto(id) ON DELETE CASCADE
);
