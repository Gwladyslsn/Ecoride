<?php
$avatarDriver = !empty($trip['avatar_user'])
    ? '/asset/uploads/avatar/' . htmlspecialchars($trip['avatar_user'])
    : '/asset/image/userIconDeafault.png';


?>


<div class="text-gray-600 body-font px-5 py-6 mx-auto flex">
    <div class="px-5 py-6 mx-auto flex">
        <div class="card p-4 rounded-lg trip">
            <div class="flex rounded-lg p-6 sm:flex-row">
                <div class="w-20 h-20 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0 overflow-hidden">
                    <img src="<?= $avatarDriver; ?>" alt="icone de profil du conducteur" class="w-full h-full object-cover rounded-full">
                </div>
                <div class="flex-grow">
                    <h2 class="text-gray-900 text-lg title-font font-semibold mb-2">
                        Trajet proposé par <?= htmlspecialchars($trip['name_user']) ?>
                    </h2>

                    <div class="mb-2">
                        <p class="text-sm text-gray-600 font-semibold uppercase">Départ</p>
                        <p class="text-black">
                            <?= htmlspecialchars($trip['departure_city']) ?> -
                            le <?= date('d/m/Y', strtotime($trip['departure_date'])) ?> à <?= htmlspecialchars($trip['departure_hour']) ?>
                        </p>
                    </div>

                    <div class="mb-2">
                        <p class="text-sm text-gray-600 font-semibold uppercase">Arrivée</p>
                        <p class="text-black">
                            <?= htmlspecialchars($trip['arrival_city']) ?> -
                            le <?= date('d/m/Y', strtotime($trip['arrival_date'])) ?> à <?= htmlspecialchars($trip['arrival_hour']) ?>
                        </p>
                    </div>

                    <div class="mb-2">
                        <p class="text-sm text-gray-600 font-semibold uppercase">Place(s) disponible(s)</p>
                        <p class="text-black">
                            <?= htmlspecialchars($trip['nb_place']) ?>
                        </p>
                    </div>

                    <a href="#" class="mt-3 text-indigo-500 inline-flex items-center">
                        Voir le détail
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
