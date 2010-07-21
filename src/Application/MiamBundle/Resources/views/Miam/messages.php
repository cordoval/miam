<?php foreach($view->session->getAttribute('_flash') as $key => $details): ?>
    <div class="flash_info">
        <?php switch($key):
        case 'story_update': printf('La story <em>"%s"</em> a été mise à jour.', $details['story']); break;
        case 'story_delete': printf('La story <em>"%s"</em> a été supprimée.', $details['story']); break;
        case 'story_create': printf('La story <em>"%s"</em> a été ajoutée au backlog.', $details['story']); break;
        case 'project_update': printf('Le projet <em>"%s"</em> a été mis à jour.', $details['project']); break;
        case 'project_create': printf('Le projet <em>"%s"</em> a été créé.', $details['project']); break;
        case 'sprint_create': printf('Le sprint <em>"%s"</em> a été créé.', $details['sprint']); break;
        endswitch
        ?>
    </div>
<?php endforeach ?>
