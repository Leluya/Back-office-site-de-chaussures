<a href="<?= $router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
<h2><?= ($editMode) ? 'Modifier' : 'Ajouter' ?>  un Produit</h2>

<form action="" method="POST" class="mt-5">
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nom de la catégorie" value="<?= $product->getName() ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" id="description" placeholder="Description du produit" aria-describedby="descriptionHelpBlock" value="<?= $product->getDescription() ?>">
        <small id="descriptionHelpBlock" class="form-text text-muted">
            La description du produit
        </small>
    </div>
    <div class="mb-3">
        <label for="picture" class="form-label">Image</label>
        <input type="text" class="form-control" name="picture" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock"  value="<?= $product->getPicture() ?>">
        <small id="pictureHelpBlock" class="form-text text-muted">
            URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
        </small>
    </div>


    <div class="mb-3">
        <label for="price" class="form-label">Prix</label>
        <input type="text" class="form-control" name="price" id="price" placeholder="10" aria-describedby="priceHelpBlock"  value="<?= $product->getPrice() ?>">
        <small id="priceHelpBlock" class="form-text text-muted">
            Le prix du produit
        </small>
    </div>
    <div class="mb-3">
        <label for="rate" class="form-label">Note</label>
        <input type="text" class="form-control" name="rate" id="rate" placeholder="5" aria-describedby="rateHelpBlock"  value="<?= $product->getRate() ?>">
        <small id="rateHelpBlock" class="form-text text-muted">
            La note du produit de 1 à 5
        </small>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Statut disponibilité</label>
        <input type="text" class="form-control" name="status" id="status" placeholder="1" aria-describedby="statusHelpBlock"  value="<?= $product->getStatus() ?>">
        <small id="statusHelpBlock" class="form-text text-muted">
            La disponibilité du produit (1=dispo, 2=pas dispo)
        </small>
    </div>

    
    <div class="mb-3">
        <label for="brand_select" class="form-label">Choisissez la marque du produit :</label>
        <select id="brand_select" class="form-select" name="brand_id" aria-describedby="brand_idHelpBlock">
            <?php foreach($brands as $brand) : ?>
                <option value="<?= $brand->getId() ?>" <?= ($brand->getId() == $product->getBrandId()) ? 'selected' : '' ?>><?= $brand->getName() ?></option>
            <?php endforeach; ?>
        </select>
        <small id="brand_idHelpBlock" class="form-text text-muted">
            La marque du produit
        </small>
    </div>


    <div class="mb-3">
        <label for="category_id" class="form-label">Catégorie</label>
        <input type="text" class="form-control" name="category_id" id="category_id" placeholder="1" aria-describedby="category_idHelpBlock"  value="<?= $product->getCategoryId() ?>">
        <small id="category_idHelpBlock" class="form-text text-muted">
            La catégorie du produit
        </small>
    </div>
    <div class="mb-3">
        <label for="type_id" class="form-label">Type</label>
        <input type="text" class="form-control" name="type_id" id="type_id" placeholder="1" aria-describedby="type_idHelpBlock"  value="<?= $product->getTypeId() ?>">
        <small id="type_idHelpBlock" class="form-text text-muted">
            Le type du produit
        </small>
    </div>


    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary mt-5"><?= ($editMode) ? 'Enregistrer les modifications' : 'Ajouter le produit' ?></button>
    </div>
</form>