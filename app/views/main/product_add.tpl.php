    <div class="container my-4">
        <a href="<?= $router->generate('produits') ?>" class="btn btn-success float-end">Retour</a>
        <h2>Ajouter un produit</h2>
        
        <form action="" method="POST" class="mt-5">
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" placeholder="Nom du produit">
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Description</label>
                <input type="text" class="form-control" id="subtitle" placeholder="Description" aria-describedby="subtitleHelpBlock">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page produit à côté de l'image
                </small>
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Prix</label>
                <input type="text" class="form-control" id="subtitle" placeholder="Prix" aria-describedby="subtitleHelpBlock">
                <small id="subtitleHelpBlock" class="form-text text-muted">
                    Sera affiché sur la page produit
                </small>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Image</label>
                <input type="text" class="form-control" id="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
                <small id="pictureHelpBlock" class="form-text text-muted">
                    URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
                </small>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary mt-5">Valider</button>
            </div>
        </form>
    </div>