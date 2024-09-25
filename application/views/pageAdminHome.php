<?php require "headerAdmin.php"?>
<title>Muscunivers | Panneau Admin</title>

<div class = "menuAdmin">
  <div class ="PanelAdmin">
    <div class = "PanelCellAdmin"> 
      <a href = "<?=site_url("Admin/admin_redirect")?>">PRODUITS</a>
    </div>
    <div class = "PanelCellAdmin"> 
      <a href = "<?=site_url("Admin/adminClient_redirect")?>">CLIENT</a>
    </div> 
    <div class = "PanelCellAdmin"> 
      <a href = "<?=site_url("Admin/adminCommande_redirect")?>">COMMANDES</a>
    </div> 