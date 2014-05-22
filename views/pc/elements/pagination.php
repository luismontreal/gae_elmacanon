<?php
$page = $data['params']['page'];
$orientation = isset($data['params']['category']) ? '/' . $data['params']['category'] : '';
$search = $data['params']['search'];
$ordering = $data['params']['ordering'] == 'newest' ? null: $data['params']['ordering'];

$queryVars = array();
if(!empty($ordering)) {
    $queryVars['order'] = $ordering;
}
$queryVars['page'] = '';
$queryString = '?' . http_build_query($queryVars);

$pageSet = ((int) ($page / 10)) * 10;
$maxPage = (int) ($data['results']['count'] / 31);

?>

<div class="navigation pagination pull-right">
    <ul>
        <?php
        if($pageSet != 0) {
            echo '<li><a href="'. $queryString  . ($pageSet - 1). '">←</a></li>';
        } 
        
        for($i = 0; $i < 10; $i++) {
            $pageToPrint = $pageSet + $i;
           
            if($pageToPrint == 0) continue;
            if($pageToPrint > $maxPage) break;
            
            if($pageToPrint == $page) {
                echo '<li class="active"><a href="#">' . $pageToPrint . '</a></li>';
            } else {
                echo '<li><a href="'. $queryString . $pageToPrint . '">' . $pageToPrint . '</a></li>';
            }
        }
        if($pageToPrint < $maxPage) {
            echo '<li><a href="' . $queryString . ($pageToPrint + 1) . '">→</a></li>';
        }
        
        ?>
    </ul>
</div>