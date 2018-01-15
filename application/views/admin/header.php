<?php
defined('BASEPATH')OR exit('No direct script access allowed');
$setting = $this->settings_model->site_settings();

if(! $setting->title){
    $title = 'Site Name';
}else{
    $title = $setting->title;
}

if(! $setting->tagline){
    $tagline = NULL;
}else{
    $tagline = ' - '.$setting->tagline;
}

if(! $setting->favicon){
    $favicon_16_x_16   = NULL;
    $favicon_32_x_32   = NULL;
    $favicon_180_x_180 = NULL;
}else{

    // for 180 x 180 apple touch
    $favicon_180_x_180_prop = array(
        'href'  => 'assets/img/favicon/180-x-180/'.$setting->favicon,
        'rel'   => 'apple-touch-icon',
        'type'  => 'image/png',
        'sizes' => '180x180'
    );

    // for 16 x 16
    $favicon_16_x_16_prop = array(
        'href'  => 'assets/img/favicon/16-x-16/'.$setting->favicon,
        'rel'   => 'icon',
        'type'  => 'image/png',
        'sizes' => '16x16'
    );

    // for 32 x 32
    $favicon_32_x_32_prop = array(
        'href'  => 'assets/img/favicon/32-x-32/'.$setting->favicon,
        'rel'   => 'icon',
        'type'  => 'image/png',
        'sizes' => '32x32'
    );
    
    $favicon_180_x_180 = link_tag($favicon_180_x_180_prop);
    $favicon_32_x_32 = link_tag($favicon_32_x_32_prop);
    $favicon_16_x_16 = link_tag($favicon_16_x_16_prop);
    
}

echo doctype('html5'); 
?>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name='robots' content='noindex,follow' />
    <base href="<?php echo base_url(); ?>">
    <title><?php echo $title; ?><?php echo $tagline; ?></title>
    <?php
        // Favicons
        echo $favicon_16_x_16; // 16x16
        echo $favicon_32_x_32; // 32x32
        echo $favicon_180_x_180; // 180x180
    ?>
	<?php
        echo link_tag('assets/css/material.cyan-light_blue.min.css');
		echo link_tag('assets/css/bootstrap.min.css');
		echo link_tag('assets/css/sb-admin.css');
        echo link_tag('assets/css/admin.css');
		echo link_tag('assets/css/font-awesome.min.css'); 

    if($this->uri->segment(2) == 'post-edit'){ 
       $summernote = link_tag('assets/libs/summernote/summernote.css');
        $bs_select = link_tag('assets/libs/bootstrap-select/bootstrap-select.css');
        $bs_jasny = link_tag('assets/libs/bootstrap-jasny/bootstrap-jasny.min.css');
        echo $summernote;
        echo $bs_select;
        echo $bs_jasny;
     }

     if($this->uri->segment(2) == 'post'){
        $summernote = link_tag('assets/libs/summernote/summernote.css');
        $bs_select = link_tag('assets/libs/bootstrap-select/bootstrap-select.css');
        $bs_jasny = link_tag('assets/libs/bootstrap-jasny/bootstrap-jasny.min.css');
        echo $summernote;
        echo $bs_select;
        echo $bs_jasny;
    }

     if($this->uri->segment(2) == 'settings'){
        echo link_tag('assets/libs/bootstrap-jasny/bootstrap-jasny.min.css');
     }
	?>

    <style>
        body,html{
            background: #fff;
            font-size: 13.5px;
            color: #424242;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-weight: 400;
        }
        ul, p, .media-body{
            font-size: 13px; 
        }
        /*Summernote*/
        .note-editor.note-frame {
            border: 1px solid #c7c5c5;
            margin-bottom: 5px;
        }
        label{
            font-weight: normal;
        }
        .circle-dot{
            font-size: 6.2px;
        }
        .title{
            font-size: 16px;
        }
        .uncontrol{
            border: 1px solid #e8e8e8;
            border-radius: 2px;
        }
        .site-logo{
            background-color: #e8e7e7;
            min-height: 100px;
            color: #b1b1b1;
            padding-top: 18%;
            width: 243px;
        }
        .site-favicon{
            width: 100px;
            padding-top: 40%;
            background-color: #d2d1d1;
            min-height: 90px;
        }
        .po-titles{
            margin-top: 5px;
        }
        
        <?php
        if($this->uri->segment('2') == 'post-edit'){
        ?>
        .feat-img-def{
            background: #dadada;
            height: 100%;
            color: #676767;
        }
        <?php }else{ ?>
        .feat-img-def{
            background: #dadada;
            padding-top: 32%;
            height: 100%;
            color: #676767;
        }
        <?php } ?>
        .user-name{
            margin-bottom: 0px;
        }
        .bs-callout-primary{
            padding: 10px 15px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-left-width: 3px;
            border-left-color: #4fa5ef;
            border-radius: 3px;
        }
        .bs-callout-danger{
            padding: 10px 15px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-left-width: 3px;
            border-left-color: #ef4f4f;
            border-radius: 1px;
        }
        .bs-callout-success {
            padding: 10px 15px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-left-width: 3px;
            border-left-color: #32d800;
            border-radius: 1px;
        }
        .bs-callout-danger > ul, .bs-callout-success > ul, .bs-callout-primary > ul{
            margin-top: 0;
            margin-bottom: 0px;
        }
        /*MDL*/
        .material-icons{
            font-size: 20px;
        }
        .mdl-badge[data-badge]:after{
            font-size: 11px;
            width: 18px;
            height: 18px;
            top: -8px;
            right: -18px;
        }
        .no-line:hover{
            text-decoration: none;
        }
        .top-15{
            margin-top: 15px;
        }
        .active-head{
            background-color: #dedede;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
                    echo anchor('admin',$title, array('class' => 'navbar-brand title')); 
                ?>
            </div>
            <ul class="nav navbar-right top-nav">
               <li>
                <div class="navbar-text user-name"> 
                 <span class="glyphicon glyphicon-user"></span>  
                <?php
                    $user = $this->ion_auth->user()->row();
                    echo $user->first_name .' '. $user->last_name;
                ?> 
                </div>
               </li>
                <li class="dropdown">
                     <a href="javascript:void(0)" class="dropdown-toggle circle-dot" data-toggle="dropdown">
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                     </a>
                     <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?php
                                echo anchor('logout/','<i class="fa fa-fw fa-power-off"></i> Log Out');
                            ?>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <?php
                        if(uri_string() == 'admin'){
                            $active_admin = 'class="active-nav"';
                        }else{
                            $active_admin = ' ';
                        }
                    ?>
                    <li <?php echo $active_admin; ?>>
                        <?php echo anchor('admin', '<i class="fa fa-fw fa-dashboard"></i> Dashboard'); ?>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#post">
                        <i class="fa fa-pencil fa-fw"></i> Post 
                        <span class="circle-dot pull-right">
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        </span>
                        </a>
                        <ul id="post" class="collapse">
                         
                    <?php
                        if($this->uri->segment(2) == 'post'){
                            $active_post = 'class="active-nav"';
                        }else{
                            $active_post = ' ';
                        }
                    ?>
                    <li <?php echo $active_post; ?>>
                        <?php
                            echo anchor('admin/post','<i class="fa fa-fw fa-edit"></i> Add');
                        ?>
                    </li>
                            <li>
                                <?php echo anchor('admin/post-list/all', '<i class="fa fa-fw fa-sort-amount-desc"></i> List'); ?>
                            </li>
                        </ul>
                    </li>
                     <?php
                        if($this->uri->segment(2) == 'category'){
                            $active_cat = 'class="active-nav"';
                        }else{
                            $active_cat = ' ';
                        }
                    ?>
                    <li <?php echo $active_cat; ?>>
                        <?php
                            echo anchor('admin/category','<i class="fa fa-fw fa-folder-open"></i> Category');
                        ?>
                    </li>
                    <?php
                        if($this->uri->segment(2) == 'tag'){
                            $active_tag = 'class="active-nav"';
                        }else{
                            $active_tag = ' ';
                        }
                    ?>
                    <li <?php echo $active_tag; ?>>
                        <?php
                            echo anchor('admin/tag','<i class="fa fa-fw fa-tags"></i> Tag');
                        ?>
                        
                    </li>
                  
                     <?php
                        if($this->uri->segment(2) == 'comment'){
                            $active_comment = 'class="active-nav"';
                        }else{
                            $active_comment = ' ';
                        }
                    ?>
                    <li <?php echo $active_comment; ?>>
                        <?php
                            echo anchor('admin/comment','<i class="fa fa-fw fa-comments"></i> Comment');
                        ?>
                    </li>
                    <?php
                        if($this->uri->segment(2) == 'settings'){
                            $active_settings = 'class="active-nav"';
                        }else{
                            $active_settings = ' ';
                        }
                    ?>
                    <li <?php echo $active_settings; ?>>
                        <?php
                            echo anchor('admin/settings','<i class="fa fa-fw fa-wrench"></i> Settings');
                        ?>
                    </li>
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-user-circle-o"></i> User 
                            <span class="circle-dot pull-right">
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        </span>
                        </a>
                        <ul id="users" class="collapse">
                            <li>
                                <?php
                                    echo anchor('auth','<i class="fa fa-fw fa-edit"></i> List');
                                ?>
                            </li>
                        </ul>
                    </li>
                     <?php
                        if($this->uri->segment(2) == 'system'){
                            $active_system = 'class="active-nav"';
                        }else{
                            $active_system = NULL;
                        }
                    ?>
                    <li <?php echo $active_system; ?>>
                        <?php
                            echo anchor('admin/system','<i class="fa fa-fw fa-info-circle"></i> System');
                        ?>
                    </li>
                </ul>
            </div>
   
        </nav>

        <div id="page-wrapper">
<div class="container-fluid">


