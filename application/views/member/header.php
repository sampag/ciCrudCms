<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?>
{doctype}
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo base_url(); ?>">
    <title>{site_title}{tagline}</title>
    {favicons}
	<?php
        echo link_tag('assets/css/material.cyan-light_blue.min.css');
        echo link_tag('assets/css/bootstrap.min.css');
        echo link_tag('assets/css/sb-admin.css');
        echo link_tag('assets/css/admin.css');
        echo link_tag('assets/css/font-awesome.min.css'); 
        
        if($this->uri->segment(2) == 'post'){
            echo link_tag('assets/libs/summernote/summernote.css');
            echo link_tag('assets/libs/bootstrap-select/bootstrap-select.css');
            echo link_tag('assets/libs/bootstrap-jasny/bootstrap-jasny.min.css');
        }
        if($this->uri->segment(2) == 'post-edit'){ 
            echo link_tag('assets/libs/summernote/summernote.css');
            echo link_tag('assets/libs/bootstrap-select/bootstrap-select.css');
            echo link_tag('assets/libs/bootstrap-jasny/bootstrap-jasny.min.css');
         }elseif($this->uri->segment(2) == 'profile'){
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
        .note-editor.note-frame {
            border: 1px solid #c7c5c5;
            margin-bottom: 5px;
        }
        label{
            font-weight: normal;
        }
        .circle-dot{
            font-size: 5px;
        }
        .title{
            font-size: 16px;
        }
        .user-avatar-default{
            background-color: #efeeee;
            height: 100%;
            color: #c5baba;
            padding-top: 32%;
        }
        .user-avatar{
            width: 17px;
            height: 17px;
            margin-right: 3px;
        }
        .uncontrol{
            border: 1px solid #e8e8e8;
            border-radius: 2px;
        }
        .feat-img-def{
            background: #dadada;
            padding-top: 32%;
            height: 100%;
            color: #676767;
        }
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
        .dropdown-menu>li>a{
            font-size: 13px;
        }
        .width-20{
            width: 20%;
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
                <?php echo anchor('member', $site_title, array('class' => 'navbar-brand')); ?>
            </div>
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-comment"></i></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="#" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>John Smith</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <div class="navbar-text user-name"> 
                {user_avatar} 
                {user}
                </div>
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
                            {logout}
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <?php
                        if(uri_string() == 'member'){
                            $member = 'class="active-nav"';
                        }else{
                            $member = ' ';
                        }
                    ?>
                    <li <?php echo $member; ?>>
                        <?php echo anchor('member', '<i class="fa fa-fw fa-dashboard"></i> Dashboard'); ?>
                    </li>
                       <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#post">
                        <i class="fa fa-pencil-square-o fa-fw"></i> Post 
                        <span class="circle-dot pull-right">
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        <i class="fa fa-circle"></i> 
                        </span>
                        </a>
                        <ul id="post" class="collapse">
	                    <li>
	                        <?php echo anchor('member/post','<i class="fa fa-fw fa-edit"></i> New'); ?>
	                    </li>
                        <li>
                            <?php echo anchor('member/post-list/all','<i class="fa fa-fw fa-sort-amount-desc"></i> List'); ?>
                        </li>
                        </ul>
                    </li>
                    <?php
                        if($this->uri->segment(2) == 'comment'){
                            $comment = 'class="active-nav"';
                        }else{
                            $comment = ' ';
                        }
                    ?>
                    <li <?php echo $comment; ?>>
                        <?php echo anchor('member/comment', '<i class="fa fa-fw fa-commenting"></i> Comment'); ?>
                    </li>
                    <?php
                        if($this->uri->segment(2) == 'profile'){
                            $profile = 'class="active-nav"';
                        }else{
                            $profile = ' ';
                        }
                    ?>
                    <li <?php echo $profile; ?>>
                        <?php echo anchor('member/profile', '<i class="fa fa-fw fa-user-circle-o"></i> Profile'); ?>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="page-wrapper">
<div class="container-fluid">



