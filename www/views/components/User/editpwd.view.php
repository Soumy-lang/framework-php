<section>
    <?php if (isset($userInfo)): ?>
        <p class="subtitle">Modifier le mot de passe de <strong><em> <?= htmlspecialchars($userInfo['username']) ?> </em></strong></p>
    <?php endif; ?>
    <div class="middle-section"><?php $this->includeComponent("form", $configForm, $errorsForm, $successForm, "button button-primary");?></div>
</section>

<footer>
    <?php if (isset($userInfo)): ?>
        <p class="text box-title"> Si vous voulez modifier le autres informations de l'utilisateur, <a href="edit-user?id=<?= htmlspecialchars($userInfo['id']) ?>" >cliquez ici. </a></p>
    <?php endif; ?>
</footer>
