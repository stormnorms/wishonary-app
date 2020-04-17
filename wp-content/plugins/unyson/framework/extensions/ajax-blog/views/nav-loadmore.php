<?php
$total   = $query->max_num_pages;
$current = $page ? $page : 1;

if ( $current >= $total ) {
    return false;
}
?>
<a href="<?php echo str_replace( '%#%', ++$current, $paginateBase ); ?>" class="btn btn-control btn-more">
    <svg class="olymp-three-dots-icon"><use xlink:href="<?php echo $reactions_img_path; ?>/icons.svg#olymp-three-dots-icon"></use></svg>
</a>