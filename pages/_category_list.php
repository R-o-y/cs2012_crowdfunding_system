<!--tag list-->
<div class="list-group">
    <?php
    foreach (Category::getAll() as $category) {
            ?>
            <a href="<?php echo url(['_page' => 'home', '_category' => $category->id]); ?>"
               class="list-group-item <?php echo $category->activate ? 'active' : '';?>">
                <?php echo $category->name; ?> <span class="badge"><?php echo $category->getBelongedNumProjects(); ?></span>
            </a>
        <?php
    }
    ?>
</div>