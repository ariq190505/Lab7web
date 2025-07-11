<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Layout Sederhana</h1>
        </header>
        <nav>
            <a href="<?= base_url('/');?>" <?= (current_url() == base_url('/')) ? 'class="active"' : '' ?>>Home</a>
            <a href="<?= base_url('/artikel');?>" <?= (strpos(current_url(), '/artikel') !== false) ? 'class="active"' : '' ?>>Artikel</a>
            <a href="<?= base_url('/about');?>" <?= (strpos(current_url(), '/about') !== false) ? 'class="active"' : '' ?>>About</a>
            <a href="<?= base_url('/contact');?>" <?= (strpos(current_url(), '/contact') !== false) ? 'class="active"' : '' ?>>Kontak</a>
        </nav>
        <section id="wrapper">
            <section id="main">
