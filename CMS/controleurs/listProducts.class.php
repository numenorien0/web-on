<?php
class listProducts extends DB
{
	private $_db;
	private $_parent = "";
	private $_mainTitre = "<a href='listProducts.php'>Catégories principales</a>";
	private $_titre = "";
	private $_advanced;
	
	public function __construct()
	{
		$this->_db = parent::__construct();
		if(isset($_GET['delete']) AND $_GET['delete'] != null)
		{
			$this->deleteProduct();
		}
		$_SESSION['arborescence'] = $_GET['parent'];
		if(!isset($_SESSION['itemPerPage']))
		{
			$_SESSION['itemPerPage'] = 20;
			header("location: listProducts.php?parent=".$_GET['parent']);
		}
		if(isset($_GET['numberItem']))
		{
			$_SESSION['itemPerPage'] = $_GET['numberItem'];
		}
		if(isset($_GET['addStock']))
		{
			$this->add_stock($_GET['IDproduct']);
		}
		echo "<input type='hidden' id='numberItem' value='".$_SESSION['itemPerPage']."'>";
// 		$this->listAll();
		

			$this->listProducts();
	}

	public function add_stock($id)
	{
		
		$sql = "SELECT * FROM produits WHERE id = $id";
		$reponse = $this->_db->query($sql);
		
		while($donnees = $reponse->fetch())
		{
			$stock = $donnees['stock'];
			//echo $stock;
			$stock = $stock + intVal($_GET['addStock']);
			
			$sql2 = "UPDATE produits SET stock = $stock WHERE id = $id";
			
			$reponse2 = $this->_db->query($sql2);
			
			exit($stock);
		}
		
		
	}
	public function listProducts()
	{
		echo "
		<div class='row cadre'>";/*Afficher <a href='?limit=1'>1</a> - <a href='?limit=2'>2</a> */echo "<a href='product.php?id=' class='add_product createPage'>+ Ajouter un produit</a></div>
		<div class='row cadre'>
			<table id='tabProduit' class='stripe' cellspacing='0' width='100%'>
				<thead>
		            <tr>
		            	<th>EAN</th>
		                <th>Nom</th>
		                <th>Prix</th>
		                <th>Type</th>
		                <th>Action</th>
		                <th>Stock</th>
		                <th>Ajout stock</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th></th>
		                <th>Nom</th>
		                <th>Prix</th>
		                <th>Type</th>
		                <th>Action</th>
		                <th>Stock</th>
		                <th>Ajout stock</th>
		            </tr>
		        </tfoot>
		        <tbody>";
					$sql2 = "SELECT devise, sepa_deci, sepa_mill, pos_devise FROM ecommerce_config WHERE id = 1";
					$reponse2 = $this->_db->query($sql2);
					while($donnees2 = $reponse2->fetch())
					{
						$deci=$donnees2['sepa_deci'];
						$mill=$donnees2['sepa_mill'];
						$devise=$donnees2['devise'];
						$pos=$donnees2['pos_devise'];
					}
					$sql = "SELECT * FROM produits WHERE id_produit = '0' ORDER BY ID DESC";
					$reponse = $this->_db->query($sql);
					while($donnees = $reponse->fetch())
					{
						$img = json_decode($donnees['medias'], true);
						$nom = json_decode($donnees['nom'], true);
					//<div style='height:50px; width:50px; background-image:url(content/products/".$img[0]."); background-size:cover;'></div>
						echo "
							<tr>
								<td>".$donnees['code_barres']."</td>
								<td>
									<a href='product.php?id=".$donnees['id']."' title='Modifier le produit ".$nom['fr']."' class='product_name'>"
										.substr($nom['fr'],0,60);
										if(strlen($nom['fr']) > 60)
										{
											echo "...";
										}
										echo "
									</a>
								</td>";
								

								
								if($donnees['prix'] != null){
									echo "<td>"; if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($donnees['prix'], 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;} echo"</td>";
									$stock = $donnees['stock'];
								}else{
									$sql3 = "SELECT * FROM produits WHERE id_produit = '".$donnees['id']."' ORDER BY prix";
									//echo $sql3;
									$reponse3 = $this->_db->query($sql3);
									$resultat = $reponse3->fetchAll();
									//print_r($resultat);
									$prixMin = $resultat[0]["prix"];
									$stock = "variable";
									$prixMax = end($resultat)["prix"];
									echo "<td>";
									if($pos == 'before-space'){echo $devise.' ';} if($pos == 'before'){echo $devise;} echo number_format($prixMin, 2 , $deci, $mill)." - ".number_format($prixMax, 2 , $deci, $mill); if($pos == 'after-space'){echo ' '.$devise;} if($pos == 'after'){echo $devise;}
									echo "</td>";
								}
								echo "
								<td>".ucfirst($donnees['type'])."</td>
								<td><a href='?delete=".$donnees['id']."' class='delete'>✖</a></td>
								<td>".$stock."</td>
								<td data-stock='".$donnees['stock']."'>";
								
								if($donnees['type'] != "variable")
								{
									echo "<input type='number' class='stockValue' data-id='".$donnees['id']."' placeholder='Ajout rapide de stock'>&nbsp&nbsp<a style='width: 35px; height: 35px' class='createPage addStock' href='#'>+</a>";
								}
								else
								{
									echo "<small style='font-size: 12px; color: #adadad; font-style: italic'>Fonction indisponible sur produit variable</small>";
								}
								
								echo "</td>
							</tr>";
			
					}
					echo "
					</tbody>
				</table>";
		
	}
		
	public function deleteProduct()
	{
		$sql2 = "DELETE FROM produits WHERE id_produit = ".$_GET['delete']." OR id = ".$_GET['delete'];
		$reponse2 = $this->_db->exec($sql2);
	
		echo "<div class='row cadre'>";
		echo "<div class='success'>Le produit a été supprimé avec succès</div>";
		echo "</div>";
	
	}	

}
?>

