-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (Kayttajatunnus, Nimi, Salasana, admin) VALUES ('Admin', 'Admin', '12345678', true);
INSERT INTO Kayttaja (Kayttajatunnus, Nimi, Salasana, admin) VALUES ('Ouzii', 'Martti Oskari Laaja', '12345678', false);


INSERT INTO Kategoria(Nimi) VALUES ('Opiskelu');

INSERT INTO Aanestys (Kategoria_id, Kayttaja_id, Nimi, Kuvaus, Kaynnissa, Sulkeutumispaiva) VALUES (1, 1, 'Opintotuki', 'Onko tuki mielestäsi riittävä', True, '2017-11-13');
INSERT INTO Aanestys (Kategoria_id, Kayttaja_id, Nimi, Kuvaus, Kaynnissa, Sulkeutumispaiva) VALUES (1, 2, 'Opintotuki', 'Onko tuki mielestäsi riittävä', True, '2017-11-13');


INSERT INTO Vaihtoehto(Aanestys_id, Vaihtoehto) VALUES (1, 1, 'Kyllä');
INSERT INTO Vaihtoehto(Aanestys_id, Vaihtoehto) VALUES (2, 1, 'Ei');

