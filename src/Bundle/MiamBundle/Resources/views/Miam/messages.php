<?php foreach($view->user->getAttribute('_flash') as $key => $details): ?>
    <div class="flash_info">
        <?php switch($key):
        case 'story_update': printf('La story <b>"%s"</b> a été mise à jour.', $details['story']); break;
        case 'story_create': printf('La story <b>"%s"</b> a été ajoutée au backlog.', $details['story']); break;
        endswitch
        ?>
    </div>
<?php endforeach ?>