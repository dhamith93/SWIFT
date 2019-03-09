<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <title><?php echo (empty($site_title) ? 'Home' : $site_title); ?></title>
</head>

<body>

     <header class="header<?php echo(empty($site_header) ? '' : $site_header);?>">
            <nav class="navigation">
                <div class="navigation__logobox">
                    <a href="<?php echo base_url();?>home"><img src="<?php echo base_url(); ?>assets/images/logo.png" class="navigation__logo" alt="Logo"></a>
                    <h1 class="navigation__logobox-title"><?php echo ($site_title == 'Home') ? ' ' : $company->name; ?></h1>
                </div>
                <ul class="navigation__nav">
                    <li class="navigation__item"><a href="<?php echo base_url(); ?>home" class="navigation__link">Home</a></li>
                    <li class="navigation__item"><a href="<?php echo base_url(); ?>press-release" class="navigation__link">Press Release</a></li>
                    <li class="navigation__item"><a href="<?php echo base_url(); ?>contacts" class="navigation__link">Contacts</a></li>
                </ul>

            </nav>


    <?php $this->load->view('public/'. lcfirst($site_view)); ?>


    <footer>
        <div class="container">
            <div class="footer">
                <div class="footer__logobox">
                    <a href="<?php echo base_url();?>home"><img src="<?php echo base_url(); ?>assets/images/logo.png" class="navigation__logo" alt="Logo"></a>
                </div>
                <h4 class="footer__text">SWIFT</h4>
                <div class="social-media">
                    <img src="<?php echo base_url();?>assets/images/image.png" class="social-media__icon" alt="">
                </div>
            </div>
        </div>
    </footer>
     

</body>

</html>