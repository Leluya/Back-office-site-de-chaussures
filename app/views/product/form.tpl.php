<a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>
<h2><?= ($editMode) ? 'Modifier' : 'Ajouter' ?>  un utilisateur</h2>

<?php if (!empty($errorList)) : ?>
<div class="alert alert-danger">
    <?php foreach ($errorList as $currentError) : ?>
    <div><?= $currentError ?></div>
    <?php endforeach ?>
</div>
<?php endif; ?>

<form action="" method="POST" class="mt-5">
    <div class="mb-3">
        <label for="lastname" class="form-label">Nom</label>
        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Nom de l'utilisateur">
    </div>
    <div class="mb-3">
        <label for="firstname" class="form-label">Prénom</label>
        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Prénom de l'utilisateur">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Adresse email de l'utilisateur">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe de l'utilisateur">
    </div>
    <div class="mb-3">
        <label for="role_select" class="form-label">Role utilisateur :</label>
        <select id="role_select" class="form-select" name="role">
            <option value="catalog-manager">Catalog-Manager</option>
            <option value="admin">Administrateur</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="status_select" class="form-label">Status utilisateur :</label>
        <select id="status_select" class="form-select" name="status">
            <option value="0">-</option>
            <option value="1">Actif</option>
            <option value="2">Désactivé</option>
        </select>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary mt-5"><?= ($editMode) ? 'Enregistrer les modifications' : 'Ajouter l\'utilisateur' ?></button>
    </div>
</form>