<?php
require_once ROOTPATH . '/src/Templates/header.php';

?>

<section class="text-gray-600 body-font relative">
    <form method="get" id="form-contact" class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-white">Contactez-nous</h1>
        </div>
        <div class="lg:w-4/5 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
                <div class="p-2 w-1/2">
                    <div class="relative">
                        <label for="firstname" class="leading-7 text-lg text-white">Prénom</label>
                        <input type="text" id="name-contact" name="nameContact" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>
                                <div class="p-2 w-1/2">
                    <div class="relative">
                        <label for="lastname" class="leading-7 text-lg text-white">Nom</label>
                        <input type="text" id="lastname-contact" name="lastnameContact" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>
                <div class="p-2 w-1/2">
                    <div class="relative">
                        <label for="email" class="leading-7 text-lg text-white">Email</label>
                        <input type="email" id="email-contact" name="emailContact" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>
                <div class="p-2 w-1/2">
                    <div class="relative">
                        <label for="phone" class="leading-7 text-lg text-white">Téléphone</label>
                        <input type="phone" id="phone-contact" name="phoneContact" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                    </div>
                </div>
                <div class="p-2 w-full">
                    <label for="message" class="leading-7 text-lg text-white">Sujet</label>
                    <select id="subject-contact" name="subjectContact" class="bg-white">
                        <option value="">--Choirsir un sujet--</option>
                        <option value="Covoiturage">Covoiturage</option>
                        <option value="Profil et compte">Profil et compte</option>
                        <option value="Suggestions / ameliorations">Suggestions / ameliorations</option>
                    </select>
                </div>
                <div class="p-2 w-full">
                    <div class="relative">
                        <label for="message" class="leading-7 text-lg text-white">Message</label>
                        <textarea id="message-contact" name="messageContact" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                </div>
                <div id="feedback-contact"></div>
                <div class="p-2 w-full">
                    <button id="btn-send" class="flex mx-auto text-white border-0 py-2 px-8 focus:outline-none rounded text-lg btn-send">Envoyer</button>
                </div>
                <div class="p-2 w-full pt-8 mt-8 border-t border-gray-200 text-center">
                    <a class="mail-ecoride">ecoride@email.com</a>
                    <p class="leading-normal my-5 text-white">49 Smith St.
                        <br>Saint Cloud, 56301
                    </p>
                </div>
            </div>
        </div>
    </form>
</section>


<?php
$page_script = '/asset/js/contact.js';
require_once ROOTPATH . '/src/Templates/footer.php'; ?>
