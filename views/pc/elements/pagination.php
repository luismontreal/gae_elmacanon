<?php
$page = $data['params']['page'];
$search = $data['params']['search'];
$pageSet = ((int) ($page / 10)) * 10;
$ordering = $data['params']['ordering'] == 'newest' ? '': '/' . $data['params']['ordering'];
?>

<div class="navigation pagination pull-right">
    <ul>
        <?php
        if($pageSet != 0) {
            echo '<li><a href="' . $ordering . '/'. $search .'/'. ($pageSet - 1). '">←</a></li>';
        } 
        
        for($i = 0; $i < 10; $i++) {
            $pageToPrint = $pageSet + $i;
           
            if($pageToPrint == 0) continue;
            
            if($pageToPrint == $page) {
                echo '<li class="active"><a href="#">' . $pageToPrint . '</a></li>';
            } else {
                echo '<li><a href="' . $ordering . '/'. $search .'/'. $pageToPrint . '">' . $pageToPrint . '</a></li>';
            }
        }
        
        echo '<li><a href="' . $ordering . '/'. $search .'/'. ($pageToPrint + 1) . '">→</a></li>';
        
        ?>
    </ul>
</div>