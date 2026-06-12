<?php
/**
 * @author   Moch Zawaruddin Abdullah
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('breadcrumbsProduct'))
{
	function breadcrumbsProduct($data = null): string
	{
        if(empty($data)){
            return '<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="'.site_url('/').'"><i class="fa fa-home font-24-line-24"></i> Material</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product not found</li>
            </ol>';
        } else {
            return '<ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="'.site_url('/').'"><i class="fa fa-home font-24-line-24"></i> Material</a></li>
                <li class="breadcrumb-item"><a href="'.site_url('produk/?id=').$data['1']['id'].'">'.$data['1']['nama'].'</a></li>
                <li class="breadcrumb-item"><a href="'.site_url('produk/?id=').$data['2']['id'].'">'.$data['2']['nama'].'</a></li>
                <li class="breadcrumb-item active" aria-current="page">'.$data['3']['nama'].'</li>
            </ol>';
        }
	}
}

if ( ! function_exists('breadcrumbsProductEngineering'))
{
    function breadcrumbsProductEngineering($data = null): string
    {
        if(empty($data)){
            return '<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="'.site_url('/').'"><i class="fa fa-home font-24-line-24"></i> Engineering</a></li>
                <li class="breadcrumb-item active" aria-current="page">Product not found</li>
            </ol>';
        } else {
            return '<ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="'.site_url('/').'"><i class="fa fa-home font-24-line-24"></i> Engineering</a></li>
                    <li class="breadcrumb-item"><a href="'.site_url($data[0]->cat_lvl_1_name).'">'.$data[0]->cat_lvl_1_name.'</a></li>
                    <li class="breadcrumb-item"><a href="'.site_url($data[0]->cat_lvl_2_name).'">'.$data[0]->cat_lvl_2_name.'</a></li>
                    <li class="breadcrumb-item active" aria-current="page">'.$data[0]->cat_lvl_3_name.'</li>
                    </ol>';
        }
    }
}