-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (Kayttajatunnus, Nimi, Salasana, admin) VALUES ('testitunnus1', 'testinen1', 'salasana1', true);


INSERT INTO Kategoria(id, Nimi) VALUES (1, 'Opiskelu');

INSERT INTO Aanestys (id, Kategoria_id, Nimi, Kuvaus, Kaynnissa, Sulkeutumispaiva) VALUES (1, 1 ,'Opintotuki', 'Onko tuki mielestäsi riittävä', True, '2017-11-13');



