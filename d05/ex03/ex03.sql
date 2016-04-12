INSERT INTO ft_table (login, date_de_creation, groupe)
  SELECT nom AS login, date_naissance AS date_de_creation, 'other' AS groupe
  FROM fiche_personne
  WHERE nom LIKE '%a%' AND LENGTH(nom) < 9
  ORDER BY nom ASC
  LIMIT 0, 10;
