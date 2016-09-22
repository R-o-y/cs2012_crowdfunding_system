<?php
if (isset($_GET['op']) && User::getCurrentUser() && User::getCurrentUser()->is_admin) {
    switch ($_GET['op']) {
        case 'delete':
            Category::checkDeleteRequest();
            break;
        case 'create':
            Category::checkCreateRequest();
            break;
        case 'edit':
            Category::checkUpdateRequest();
            break;
    }
    //redirect(url(['_page' => 'home']));
}