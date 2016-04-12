SELECT titre, resum
  FROM film
  WHERE LOWER(resum) LIKE '%vincent%'
  ORDER BY id_film ASC;