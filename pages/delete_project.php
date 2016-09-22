<?php
if (isset($_GET['project_id']) && User::getCurrentUser()) {
    $project = Project::getProjectById($_GET['project_id']);
    if ($project && ($project->owner_id == User::getCurrentUser()->id || User::getCurrentUser()->is_admin)) {
        $project->delete();
    }
    redirect(url(['_page' => 'home']));
}