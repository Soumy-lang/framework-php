<h3 class="box-title">Modifier l'utilisateur</h3>
<section class="middle-section">
    <div class="form-bloc"><?php $this->includeComponent("form", $configForm, $errorsForm, $successForm, "button button-primary");?></div>
</section>

<footer>
    <?php if (isset($userInfo)): ?>
        <p class="text box-title"> Si vous voulez modifier le mot de passe de l'utilisateur, <a href="edit-password?id=<?= htmlspecialchars($userInfo['id']) ?>" >cliquez ici. </a></p>
    <?php endif; ?>
</footer>
