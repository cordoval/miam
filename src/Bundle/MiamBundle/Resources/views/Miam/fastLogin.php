<div class="flash_info fast_login">
    Tu n'es pas connecté !
    <?php foreach($users as $user): ?>
    <a class="fast_login_user" href="<?php echo $view->router->generate('fast_login', array('username' => $user->getUsername())) ?>"><?php echo $user->getUsername() ?></a>
    <?php endforeach; ?>
</div>
