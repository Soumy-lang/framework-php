<section class="connection-box">
    <div class="box-title"><h3>Installer votre site</h3></div>
    <div class="box-content">
        <p class="text">Remplissez les champs ci-dessous pour installer votre site. Ajoutez un premier utilisateur admin et le prefix pour nommer vos table en base de données</p>
    </div>
    <div class="box-content">
        <?php $this->includeComponent("form", $configForm, $errorsForm, $successForm, "button button-primary");?>
    </div>
</section>
