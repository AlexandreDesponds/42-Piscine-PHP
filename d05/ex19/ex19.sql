/*
Exercice pas claire, j'ai deux interpretations
-> Différence de visionnage de tous les films

SELECT DATEDIFF(MAX(date), MIN(date)) as 'uptime'
  FROM historique_membre;

-> Différence de visionnage par film
*/
SELECT DATEDIFF(MAX(date), MIN(date)) as 'uptime'
FROM historique_membre
GROUP BY id_film;