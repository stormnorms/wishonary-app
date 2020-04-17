<?php

if ( !defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array(
    'blog_style'      => apply_filters( 'crumina_option_blog_style', array(
        'label'   => esc_html__( 'Blog style', 'olympus' ),
        'desc'    => esc_html__( 'Select default style for display posts. Alternatively can be changed in page with template called "Blog page"', 'olympus' ),
        'type'    => 'radio',
        'value'   => 'classic',
        'choices' => array(
            'classic' => esc_html__( 'Classic', 'olympus' ),
            'grid'    => esc_html__( 'Grid', 'olympus' ),
            'list'    => esc_html__( 'List', 'olympus' ),
            'masonry' => esc_html__( 'Masonry', 'olympus' ),
        ),
    ) ),
    'blog_pagination' => apply_filters( 'crumina_option_blog_nav_style', array(
        'label'   => esc_html__( 'Pagination style', 'olympus' ),
        'desc'    => esc_html__( 'Select default style for pagination. Loadmore work with Ajax sort panels only', 'olympus' ),
        'type'    => 'radio',
        'value'   => 'nav',
        'choices' => array(
            'nav' => esc_html__( 'Numeric', 'olympus' ),
        ),
    ) ),
    'post_order'      => apply_filters( 'crumina_option_blog_post_order', array(
        'label'   => esc_html__( 'Order', 'olympus' ),
        'type'    => 'radio',
        'value'   => 'DESC',
        'desc'    => esc_html__( 'Designates the ascending or descending order of items', 'olympus' ),
        'choices' => array(
            'DESC' => esc_html__( 'Descending', 'olympus' ),
            'ASC'  => esc_html__( 'Ascending', 'olympus' ),
        ),
    ) ),
    'post_order_by'   => apply_filters( 'crumina_option_blog_post_order_by', array(
        'label'   => esc_html__( 'Order By', 'olympus' ),
        'type'    => 'radio',
        'desc'    => esc_html__( 'Sort retrieved posts by parameter.', 'olympus' ),
        'value'   => 'date',
        'choices' => array(
            'date'          => esc_html__( 'Order by date', 'olympus' ),
            'comment_count' => esc_html__( 'Order by number of comments', 'olympus' ),
            'author'        => esc_html__( 'Order by author.', 'olympus' ),
        ),
    ) ),
    'categories'      => array(
        'type'       => 'multi-select',
        'label'      => esc_html__( 'Categories', 'olympus' ),
        'help'       => esc_html__( 'Click on field and type category name to find  category', 'olympus' ),
        'population' => 'taxonomy',
        'source'     => 'category',
        'limit'      => 100,
    ),
    'cat_exclude'     => array(
        'type'  => 'checkbox',
        'value' => false,
        'label' => esc_html__( 'Exclude selected', 'olympus' ),
        'desc'  => esc_html__( 'Show all categories except that selected in "Categories" option', 'olympus' ),
        'text'  => esc_html__( 'Exclude', 'olympus' ),
    ),
    'posts_per_page'  => array(
        'label' => esc_html__( 'Items per page', 'olympus' ),
        'desc'  => esc_html__( 'How many posts show per page', 'olympus' ),
        'help'  => esc_html__( 'Please input number here. Leave empty for default value', 'olympus' ),
        'type'  => 'text',
        'value' => 12
    ),
);
