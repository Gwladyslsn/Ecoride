<?php

require_once ROOTPATH . '/src/Templates/header.php'; ?>


<h1 class="text-center text-3xl mt-4">Mentions légales</h1> <br />
<br />
<section class="text-md">
    <div class="m-5">
        <h2 class="text-xl">1. Identification de l’éditeur</h2>
        Le site ECORIDE est édité par : ........<br />
        Raison sociale: [Nom de la société ou de la personne] <br />
        Siège social : [Adresse complète] <br />
        Numéro SIRET : [Numéro SIRET] Responsable de la publication : [Nom et
        prénom] <br />
        Contact : [Adresse e-mail et/ou numéro de téléphone] <br />
        <br />

        <h2 class="text-xl">2. Hébergeur du site</h2>
        Le site est hébergé par : Nom de l’hébergeur : [Nom de l’hébergeur] <br />
        Adresse : [Adresse complète] <br />
        Contact : [E-mail et/ou téléphone de l’hébergeur] <br />
        <br />

        <h2 class="text-xl">3. Propriété intellectuelle </h2>
        L’ensemble des contenus présents sur le site (textes, images, logos, etc.)
        est protégé par les lois en vigueur sur la propriété intellectuelle. Toute
        reproduction ou représentation, totale ou partielle, sans l’autorisation
        préalable écrite de [Nom de l’éditeur] est interdite. <br />
        <br />

        <h2 class="text-xl">4. Données personnelles </h2>
        Conformément au Règlement Général sur la Protection des Données (RGPD),
        les informations recueillies sur le site ECORIDE sont utilisées
        uniquement dans le cadre des services proposés. Vous disposez d’un droit
        d’accès, de rectification et de suppression de vos données personnelles en
        écrivant à contact2ecoride@gmail.com. <br />
        <br />

        <h2 class="text-xl">5. Responsabilité </h2>
        [Nom de l’éditeur] ne peut être tenu responsable des dommages directs ou
        indirects résultant de l’utilisation du site ou de l’impossibilité d’y
        accéder. <br />
        <br />

        <h2 class="text-xl">6. Contact </h2>
        Pour toute question ou réclamation, vous pouvez nous contacter à l’adresse
        suivante : contact2ecoride@gmail.com ou via notre <a href="<?= BASE_URL ?>?controller=page&action=contact">formulaire de contact</a>.
    </div>
</section>

<?php
require_once ROOTPATH . '/src/Templates/footer.php'; ?>