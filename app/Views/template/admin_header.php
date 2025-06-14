<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?> - Admin Panel</title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
        <header>
            <h1>Admin Panel - Lab7Web</h1>
        </header>
        <nav>
            <a href="<?= base_url('/admin/artikel');?>" class="active">Dashboard</a>
            <a href="<?= base_url('/admin/artikel');?>">Artikel</a>
            <a href="<?= base_url('/admin/artikel/add');?>">Tambah Artikel</a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <div class="admin-content">
                    <h1><?= $title; ?></h1>
                    <hr>
