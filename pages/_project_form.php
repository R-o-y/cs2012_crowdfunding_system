<div class="form-group">
    <label for="project_title" class="col-sm-2 control-label">Title</label>
    <div class="col-sm-10">
        <input type="text"
               value="<?php echo (isset($project)) ? $project->title : '' ?>"
               class="form-control" id="project_title" name="project_title" placeholder="Please input title here..">
    </div>
</div>
<div class="form-group">
    <label for="project_description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <textarea class="form-control" id="project_description" name="project_description"><?php echo (isset($project)) ? $project->description : '' ?></textarea>
    </div>
</div>
<div class="form-group">
    <label for="project_goal" class="col-sm-2 control-label">Goal</label>
    <div class="col-sm-10">
        <input type="text"
               value="<?php echo (isset($project)) ? $project->goal : '' ?>"
               class="form-control" id="project_goal" name="project_goal" placeholder="What's your goal?">
    </div>
</div>
<div class="form-group">
    <label for="project_start_date" class="col-sm-2 control-label">Start date</label>
    <div class="col-sm-10">
        <input type="text"
               value="<?php echo (isset($project)) ? $project->start_date->format('d/m/Y') : '' ?>"
               class="form-control" id="project_start_date" name="project_start_date">
    </div>
</div>
<div class="form-group">
    <label for="project_duration" class="col-sm-2 control-label">Duration</label>

    <div class="col-sm-10">
        <input type="text"
               value="<?php echo (isset($project)) ? $project->duration : '' ?>"
               class="form-control" id="project_duration" name="project_duration" placeholder="How long should it be?">
    </div>
</div>
<div class="form-group">
    <label for="project_categories" class="col-sm-2 control-label">Categories</label>

    <div class="col-sm-10">
        <select id="project_categories" name="project_categories[]" multiple="multiple">
            <?php
            $selected_categories = [];
            if (isset($project)) {
                foreach ($project->getCategories() as $category) {
                    array_push($selected_categories, $category->id);
                }
            }
            foreach (Category::getAll() as $category) {
               ?>
                <option value="<?php echo $category->id; ?>"
                    <?php echo in_array($category->id, $selected_categories) ? 'selected' : '';?>><?php echo $category->name; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
</div>
<input type="hidden"
       value="<?php echo (isset($project)) ? $project->id : '' ?>"
       id="project_id"
       name="project_id"
>
