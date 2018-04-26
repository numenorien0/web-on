<style>
.ecommerce-link .tab-title
{
	margin-top:10px;
	color: #232323;
}
.ecommerce-link
{
	transition: all linear 0.2s;
	height: 100%;
	padding-top: 15px;
	padding-bottom: 15px;
}

.ecommerce-link:hover
{
	transform: scale(1.05);
}
.menuEcommerce a.active
{
	
}
.ecommerce-link.active
{
	background: #4999cf;
	
}
.ecommerce-link.active .tab-title
{
	color: white;
}
</style>
<script>
	$(function(){
	var url = window.location.pathname;
	var filename = url.substring(url.lastIndexOf('/')+1);
	
	$('.menuEcommerce a').each(function(){
		if($(this).attr('href') == filename)
		{
			$(this).children(".ecommerce-link").addClass("active");
		}
	})
		
		
	})
</script>
<?php
	echo "<div class='row menuEcommerce' style='margin-left:0; margin-right:0;'><div class='col-sm-12 col-lg-10 col-lg-offset-1 cadre' style='margin-bottom:0; padding: 0'>";
		echo "<a href='ecommerce.php' title='Dashboard E-Commerce'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/home.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Dashboard</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='listProducts.php' title='Liste des produits'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/package.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Produits</p>";
			echo "</div>";
		echo"</a>";
		echo "<a href='listClients.php' title='Liste des clients'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/network.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Clients</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='listCommandes.php' title='Liste des produits'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/packs.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Commandes</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='listFactures.php' title='Liste factures E-Commerce'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/receipt.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Factures</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='codesPromo.php' title='Liste des codes promo E-Commerce'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/coupon.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Codes Promo</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='caisse.php' title='Caisse'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/caisse.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Caisses</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='listCommentaires.php' title='chat E-Commerce'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/chat.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Commentaires</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='rapports.php?tab=vuedensemble' title='Rapports de performance'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/chart.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Rapports</p>";
			echo "</div>";
		echo "</a>";
		echo "<a href='optionsEcommerce.php' title='Options E-Commerce'>";
			echo "<div class='ecommerce-link'>";
				echo "<img src='images/ecommerce/settings.png' width='30%' style='display:block; margin:auto;'>";
				echo"<p class='text-center tab-title'>Configuration</p>";
			echo "</div>";
		echo "</a>";
	echo "</div></div>";
?>

