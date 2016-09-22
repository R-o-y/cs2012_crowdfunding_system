<?php
if (isset($_GET['category_id'])) {
    $category = Category::getCategoryById($_GET['category_id']);
    if ($category) {
        $category->delete();
    }
    redirect(url(['_page' => 'home']));
}