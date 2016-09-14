<!--tag list-->
<div class="list-group">
    <?php
    foreach (Category::getAll() as $category) {
        if ($category->activate) {
            ?>
            <a href="<?php echo url(['_page' => 'home', '_category' => $category->id]); ?>"
               class="list-group-item active">
                <?php echo $category->name; ?> <span class="badge"><?php echo $category->getBelongedNumProjects(); ?></span>
            </a>
            <?php
        } else {
            ?>
            <a href="<?php echo url(['_page' => 'home', '_category' => $category->id]); ?>" class="list-group-item">
                <?php echo $category->name; ?> <span class="badge"><?php echo $category->getBelongedNumProjects(); ?></span>
            </a>
            <?php
        }
    }
    ?>
</div>