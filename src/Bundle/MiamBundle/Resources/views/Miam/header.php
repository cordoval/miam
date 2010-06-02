<header class="hd">
    <div class="content">
        <h1 class="title_header">
            <a href="<?php echo $view->router->generate('backlog') ?>" id="logo">MIAM</a>
        </h1>
        <div class="auth">
            <?php if($user = $view->user->getAttribute('identity')): ?>
                <span class="username"><?php echo $user; ?></span>
                <a href="<?php echo $view->router->generate('logout') ?>">Logout</a>
            <?php else: ?>
                <a href="<?php echo $view->router->generate('login') ?>">Login</a>
            <?php endif; ?>
        </div>
        <div class="menu">
            <ul>
                <?php $activeMenu = $view->slots->get('active_menu') ?>
                <li><a <?php if('timeline' === $activeMenu): ?>class="active"<?php endif ?> href="<?php echo $view->router->generate('timeline') ?>">TIMELINE</a></li>
                <li><a <?php if('backlog' === $activeMenu): ?>class="active"<?php endif ?> href="<?php echo $view->router->generate('backlog') ?>">BACKLOG</a></li>
                <li><a <?php if(in_array($activeMenu, array('sprint_new', 'sprint_current'))): ?>class="active"<?php endif ?> href="<?php echo $view->router->generate('sprint_current') ?>">SPRINT</a></li>
                <li><a <?php if('projects' === $activeMenu): ?>class="active"<?php endif ?> href="<?php echo $view->router->generate('projects') ?>">PROJETS</a></li>
                <li><a <?php if('story_new' === $activeMenu): ?>class="active"<?php endif ?> href="<?php echo $view->router->generate('story_new') ?>">NOUVELLE STORY</a></li>
            </ul>
        </div>
    </div>
</header>
