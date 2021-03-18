<!DOCTYPE html>
<html lang="en">


<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Não deixe de anunciar</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/bootstrap.min.css'); ?>">

    <link rel="stylesheet" href="<?php echo base_url('public/web/assets/css/LineIcons-free.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/fonts/line-icons.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/slicknav.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/color-switcher.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/animate.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/owl.carousel.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/main.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/css/responsive.css'); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/web/assets/autocomplete/jquery-ui.css'); ?>">

	<?php if (isset($styles)): ?>

		<?php foreach ($styles as $estilo): ?>

			<link rel="stylesheet" href="<?php echo base_url('public/restrita/' . $estilo); ?>">

		<?php endforeach; ?>

	<?php  endif; ?>

	         <style>

	         	#DataTables_Table_o_length {
	         		Margin-left: 17px;
	         		}

	         	#DataTables_Table_o_length .form-control{
	         		padding: 0;
	         		padding-left: 10px;
	         		}

	         		.select2-container--default .select2-selection--single {
	         			border: lpx solid #e5e5e5;
	         			border-radius: 4px;
	         			font-weight: 400;
	         		}

	         		.select2-container .select2-selection--single {

	         		}
	         		.select2-container--default .select2-selection--single .select2-selection__rendered {
	         			line-height: 38px;
	         		}

	         		.select2-container--default .select2-selection--single .select2-selection_arrow {
	         			top: 5px;
	         		}
	         		
	         </style>
</head>
<body>