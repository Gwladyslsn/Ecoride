<?php

require_once ROOTPATH . 'src/Templates/header.php';
?>


<h1 class="text-center text-3xl mt-4">Mentions légales</h1> <br />
<br />
<section class="text-md">
    <div class="m-5">
        <h2 class="text-xl">1. Identification de l’éditeur</h2>
        Le site ECORIDE est édité par : Gwladys Laisné<br />
        Raison sociale: Ecoride - [projet réalisé dans le cadre de la formation Studi] <br />
        Siège social : 95490 <br />
        Numéro SIRET : 000000000000 <br />
        Responsable de la publication : Gwladys Laisné <br />
        Contact : gwladyslaisne@outlook.fr <br />
        <br />

        <h2 class="text-xl">2. Hébergeur du site</h2>
        Le site est hébergé par : Nom de l’hébergeur : Heroku, plateforme cloud gérée par Salesforce Inc. <br />
        Adresse : Salesforce Tower, 415 Mission Street, 3rd Floor, San Francisco, CA 94105, États-Unis <br />
        Contact : https://www.heroku.com <br />

        Base de données NoSQL hébergée sur : MongoDB Atlas – MongoDB Inc. <br />
        Adresse : 1633 Broadway, 38th Floor, New York, NY 10019, États-Unis <br />
        Contact : https://www.mongodb.com/cloud/atlas<br />
        <br />

        <h2 class="text-xl">3. Propriété intellectuelle </h2>
        L’ensemble des contenus présents sur le site Ecoride (textes, images, codes sources, logos, etc.)
        est protégé par les lois en vigueur sur la propriété intellectuelle. Toute reproduction, représentation, modification, 
        publication, transmission ou dénaturation, totale ou partielle, du site ou de son contenu, par quelque procédé que ce soit, 
        sans l’autorisation écrite préalable de la société Ecoride, est strictement interdite. <br />
        <br />

        <h2 class="text-xl">4. Données personnelles </h2>
        Conformément au Règlement Général sur la Protection des Données (RGPD),
        les informations recueillies sur le site ECORIDE sont utilisées
        uniquement dans le cadre des services proposés. Vous disposez d’un droit
        d’accès, de rectification et de suppression de vos données personnelles en
        écrivant à contact2ecoride@gmail.com. <br />
        <br />

        <h2 class="text-xl">5. Responsabilité </h2>
        Ecoride ne peut être tenu responsable des dommages directs ou
        indirects résultant de l’utilisation du site ou de l’impossibilité d’y
        accéder. <br />
        <br />

        <h2 class="text-xl">6. Contact </h2>
        Pour toute question ou réclamation, vous pouvez nous contacter à l’adresse
        suivante : contact2ecoride@gmail.com ou via notre <a href="<?= BASE_URL ?>?controller=page&action=contact">formulaire de contact</a>.
    </div>
</section>

<?php
require_once ROOTPATH . 'src/Templates/footer.php'; ?>
