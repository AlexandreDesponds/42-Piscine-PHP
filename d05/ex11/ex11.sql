SELECT UPPER(fiche_personne.nom) AS 'NOM', fiche_personne.prenom, abonnement.prix
  FROM membre
  INNER JOIN abonnement ON abonnement.id_abo = membre.id_abo
  INNER JOIN fiche_personne ON fiche_personne.id_perso = membre.id_membre
  WHERE abonnement.prix > 42
  ORDER BY fiche_personne.nom ASC, fiche_personne.prenom ASC;