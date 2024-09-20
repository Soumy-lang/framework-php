<h2 class="box-title">Tous les utilisateurs</h2>
    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p class="text"><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success">
            <?php foreach ($success as $message): ?>
                <p class="text"><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<section class="section1-user-table">
<div class="user-table">
    <table>
        <thead class="responsive-th">
            <tr>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="responsive-tb">
            <?php

                foreach ($users as $userData): ?>
                <tr>
                    <td><?php echo $userData['firstname']; ?></td>
                    <td><?php echo $userData['email']; ?></td>
                    <td><?php echo $userData['role']; ?></td>
                    <td class="link-list">
                        <a href="/bo/user/view-user?id=<?php echo $userData['id']; ?>" class="link-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="/bo/user/edit-user?id=<?php echo $userData['id']; ?>" class="link-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <a href="/bo/user?action=delete&id=<?php echo $userData['id']; ?>" class="link-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</section>
