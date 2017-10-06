-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja (Kayttajatunnus, Nimi, Salasana) VALUES ('testitunnus1', 'testinen1', 'salasana1');
INSERT INTO Kayttaja (Kayttajatunnus, Nimi, Salasana) VALUES ('testitunnus2', 'testinen2', 'salasana2');

INSERT INTO Kategoria(id, Nimi) VALUES (1, 'Opiskelu');

INSERT INTO Aanestys (id, Kategoria_id, Nimi, Kuvaus, Kaynnissa, Sulkeutumispaiva) VALUES (1, 1 ,'Opintotuki', 'Onko tuki mielestäsi riittävä', True, '2017-11-13');
INSERT INTO Aanestys (id, Kategoria_id, Nimi, Kuvaus, Kaynnissa, Sulkeutumispaiva) VALUES (2, 1 ,'Opintotuki1','Viime aikoina opintotukea on leikattu merkittävästi. Onko mielestäsi opintotuki tällä hetkellä riittävän suuri?', True, '2017-11-14');


