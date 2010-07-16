<header class="hd">
    <div class="content">
        <h1 class="title_header">
            <a href="<?php echo $view->router->generate('homepage') ?>" id="logo">MIAM</a>
        </h1>
        <div class="menu">
            <ul>
                <?php $activeMenu = $view->slots->get('active_menu') ?>
                <li><a <?php if('projects' === $activeMenu): ?>class="active"<?php endif ?> href="<?php echo $view->router->generate('projects') ?>">PROJETS</a></li>
            </ul>
        </div>
    </div>
</header>
