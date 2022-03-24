<h2>Se connecter</h2>

<?php if (!empty($errorList)) : ?>
<div class="alert alert-danger">
    <?php foreach ($errorList as $currentError) : ?>
    <div><?= $currentError ?></div>
    <?php endforeach ?>
</div>
<?php endif; ?>

<?php if (!empty($confirmList)) : ?>
<div class="alert alert-info">
    <?php foreach ($confirmList as $currentConfirm) : ?>
    <div><?= $currentConfirm ?></div>
    <?php endforeach ?>
</div>
<?php endif; ?>

<form action="" method="POST" class="mt-5">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" name="email" class="form-control" id="email" placeholder="Votre adresse email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Votre mot de passe">
    </div>
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary mt-5">Se connecter</button>
    </div>
</form>