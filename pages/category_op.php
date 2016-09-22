<?php
if (isset($_GET['op'])) {
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