<?php
if (isset($_GET['project_id'])) {
    $project = Project::getProjectById($_GET['project_id']);
    if ($project) {
        $project->delete();
    }
    redirect(url(['_page' => 'home']));
}