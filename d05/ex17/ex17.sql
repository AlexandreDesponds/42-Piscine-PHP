SELECT COUNT(*) AS 'nb_abo', FLOOR(AVG(prix)) AS 'moy_abo', MOD(SUM(duree_abo), 42) as 'ft'
  FROM abonnement