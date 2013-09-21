<!DOCTYPE html>
<html>
    <head>
	<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ateliers de Pontaury - <?php echo $title; ?></title>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <?php echo Asset::css('bootstrap.css'); ?>
        <?php echo Asset::css('bootstrap-responsive.css'); ?>
        <?php echo Asset::css('gesta.css'); ?>
        <?php echo Asset::css('bootstrap-notify.css'); ?>

        <?php // echo Asset::css('bootstrap.min.css'); ?>
        <?php echo Asset::css('jquery.css'); ?>
        <?php echo Asset::css('jquery.jgrowl.css'); ?>
        <?php //echo Asset::css('jquery.gantt.css'); ?>
        <?php //echo Asset::css('boutons.css'); ?>
        <?php echo Asset::js('jquery-1.7.1.min.js'); ?>
        <?php echo Asset::js('jquery-ui-1.8.17.custom.min.js'); ?>

        <?php echo Asset::js('jquery-custom.js'); ?>
        <?php echo Asset::js('jquery.maskedinput-1.3.min.js'); ?>
        <?php echo Asset::js('jquery.jgrowl.js'); ?>
        <?php //echo Asset::js('jquery.gantt.js'); ?>
        <?php echo Asset::js('bootstrap.min.js'); ?>
        <?php echo Asset::js('bootstrap-dropdown.js'); ?>


        <!-- Pour le session::set_flash -->
        <?php
            $errors = Session::get_flash('error');

            if(!empty($errors)):
                $msg = null;

            foreach ($errors as $message) {
                $msg .="<li>" . $message . "</li>";
            }
                Session::keep_flash('error');
        ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $.jGrowl(
                            <?php echo '"' . $msg . '"' ?>,
                            {life: 10000}
                        );
                });
            </script>
        <?php endif; ?>
        <?php
            $success = Session::get_flash('success');
            if(!empty($success)):
                $msg = null;

            foreach ($success as $message) {
                $msg .="<b>" . $message . "</b><br />";
            }
        ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $.jGrowl(
                            <?php echo '"' . $msg . '"' ?>,
                            {life: 10000,
                            theme: 'success'}
                        );
                });
            </script>
        <?php endif; ?>

    </head>

    <body data-spy="scroll" data-target=".navbar">

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">

                    <a class="brand" href="<?php echo Uri::create('/'); ?>">Ateliers de Pontaury</a>
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">
                            <?php if($current_user): ?>
                            <?php echo Auth::instance()->get_screen_name() ?> |
                            <?php echo Html::anchor('users/logout', 'Quitter') ?>
                            <?php else: ?>
                            <?php echo Html::anchor('users/login', 'Connexion') ?>
                            <?php endif; ?>
                            <span class="hidden-phone"> | <b> <?php echo date('d M Y'); ?></b></span>
                        </p>
                        <ul class="nav" role="navigation">
<!--                            <li>--><?php //echo Html::anchor('/', 'Accueil', array('id' => 'link_home')) ?><!--</li>-->
                            <li class="dropdown hidden-phone">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Participant <b class="caret"></b></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a tabindex="-1" href="<?php echo Uri::create('participant/ajouter'); ?>">Ajouter</a></li>
                                    <li><a tabindex="-1" href="<?php echo Uri::create('gesta/choisir/modifier'); ?>">Modifier</a></li>
                                    <li><a tabindex="-1" href="<?php echo Uri::create('gesta/choisir/supprimer'); ?>">Supprimer</a></li>
                                    <li><a tabindex="-1" href="<?php echo Uri::create('listeattente'); ?>">Liste Candidat</a></li>

                                </ul>
                            </li>
                            <li class="hidden-phone"><?php echo Html::anchor('contrat','Contrat',array('id'=>'link_contrat'))?></li>

                            <li class="dropdown hidden-phone">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Prestation <b class="caret"></b></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a tabindex="-1" href="<?php echo Uri::create('prestation'); ?>">Prestation par participant</a></li>
                                    <li><a tabindex="-1" href="<?php echo Uri::create('tableau'); ?>">Prestation par Groupe</a></li>


                                </ul>
                            </li>

                            <li class="hidden-phone"><?php echo Html::anchor('document','Document',array('id'=>'link_document'))?></li>
                            <li class="hidden-phone"><?php echo Html::anchor('statistique','Statistique',array('id'=>'link_liste'))?></li>
                            <li class="hidden-phone"><?php echo Html::anchor('administration','Admin',array('id'=>'link_admin'))?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div id="content">JE SUIS UN TEMPLATE ADMIN PHP
            <?php echo $content; ?>
        </div>

        <div id="footer">
            <div class="pull-center"><a href="">Gesta v3.0</a> &#169; Ateliers de Pontaury</div>
	</div>

        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
        <?php // echo Asset::js('jquery.js'); ?>
        <?php echo Asset::js('bootstrap-transition.js'); ?>
        <?php echo Asset::js('bootstrap-alert.js'); ?>
        <?php echo Asset::js('bootstrap-modal.js'); ?>
        <?php echo Asset::js('bootstrap-dropdown.js'); ?>
        <?php echo Asset::js('bootstrap-scrollspy.js'); ?>
        <?php echo Asset::js('bootstrap-tab.js'); ?>
        <?php //echo Asset::js('bootstrap-notify.js'); ?>
        <?php echo Asset::js('bootstrap-tooltip.js') ?>
        <?php echo Asset::js('bootstrap-popover.js'); ?>
        <?php // echo Asset::js('bootstrap-button.js'); ?>
        <?php // echo Asset::js('bootstrap-collapse.js'); ?>
        <?php // echo Asset::js('bootstrap-carousel.js'); ?>
        <?php // echo Asset::js('bootstrap-typeahead.js'); ?>
        <?php // echo Asset::js('bootstrap-affix.js'); ?>


    </body>
</html>