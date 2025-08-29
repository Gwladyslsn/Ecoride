<?php

require_once ROOTPATH . '/src/Templates/header.php';

?>

<body>
        <div class="main-content">
            <div class="info-section">
                <h3>Information</h3>
                <p>Utilisez ce formulaire pour ajouter un nouveau membre à l'équipe ECORIDE. Tous les champs marqués d'un astérisque (*) sont obligatoires.</p>
            </div>

            <div id="feedbackAddEmployee"></div><br>

            <form class="form-section" id="employeeForm">
                <h2 class="section-title">Informations de l'employé</h2>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom">Nom <span>*</span></label>
                        <input type="text" id="lastname_employee" name="lastname_employee" placeholder="Entrez le nom de famille">
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom <span>*</span></label>
                        <input type="text" id="name_employee" name="name_employee" placeholder="Entrez le prénom">
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span>*</span></label>
                        <input type="email" id="email_employee" name="email_employee" placeholder="exemple@ecoride.com">
                    </div>

                    <div class="form-group">
                        <label for="telephone">Téléphone <span>*</span></label>
                        <input type="tel_employee" id="tel_employee" name="tel_employee" placeholder="0123456789">
                    </div>

                    <div class="form-group">
                        <label for="dateEmbauche">Date d'embauche <span>*</span></label>
                        <input type="date" id="dateHire_employee" name="dateHire_employee">
                    </div>

                    <div class="form-group">
                        <label for="password">Mot de passe <span>*</span></label>
                        <input type="password" id="password_employee" name="password_employee">
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary" id="btn-add-employee">
                        ✅ Ajouter l'employé
                    </button>
                    <button type="reset" class="btn btn-secondary" id="btn-reset">
                        🔄 Effacer le formulaire
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="/asset/js/addEmployee.js"></script>

    <?php

    require_once ROOTPATH . '/src/Templates/footer.php';

    ?>