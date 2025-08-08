
<footer class="footer footer-horizontal footer-center text-base-content p-10">
    <nav class="grid grid-flow-col gap-4">
        <a href="<?= BASE_URL ?>about" class="link link-hover">A propos</a>
        <a href="<?= BASE_URL ?>contact" class="link link-hover">Contact</a>
        <a href="<?= BASE_URL ?>reviewEcoride" class="link link-hover">Laisser un avis</a>
        <a href="<?= BASE_URL ?>register" class="link link-hover">Connexion</a>
        <a href="<?= BASE_URL ?>register" class="link link-hover">Inscription</a>
    </nav>
    <aside>
        <p>Copyright © 2025 - All right reserved by Eco'ride - <a href="<?= BASE_URL ?>mentions" class="link link-hover">Mentions légales</a></p>
    </aside>
</footer>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

<?php if (isset($page_script)): ?>
        <script src="<?php echo $page_script; ?>"></script>
    <?php endif; ?>
</body>

</html>
