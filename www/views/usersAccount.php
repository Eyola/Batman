<title>Comptes des utilisateurs</title>

<div class="container d-flex flex-column align-items-center">
    <table class="table">
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?= $user->getFirstName() ?></td>
                    <td><?= $user->getname() ?></td>
                    <td><?= $user->getMail() ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="container d-flex flex-column align-items-center">
    <div>
        <form action="<?= BASE_URL . 'addUser'; ?>" method="post">
            <label for="firstName">Prénom</label>
            <input type="text" name="firstName" class="form-control">

            <label for="name">Nom</label>
            <input type="text" name="name" class="form-control">

            <label for="mail">Adresse mail</label>
            <input type="email" name="mail" class="form-control">

            <label for="password">Mot de passe</label>
            <input type="password" name="password" class="form-control">

            <label class="form-label" for="role">Type</label>
            <select class="form-select" type="type" name="role" aria-label="Default select example">
                <?php foreach ($roleList as $role) { ?>
                    <option class="" value="<?= $role->getRole() ?>"><?= $role->getRole() ?></option>
                <?php
                }
                ?>
            </select>

            <input type="submit" class="btn btn-success m-3" value="Créer utilisateur">
        </form>
    </div>