	<?php

function connect_db()
{	 
		try
				{
        $BD = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root','root');
        $BD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        }
				catch (PDOException $e) 
				{
					die('Erreur : ' . $e->getMessage());
				}
      return $BD;
}
	?>
