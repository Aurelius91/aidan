<!DOCTYPE html>
<html lang="en">
<head>
    <? $this->load->view('header'); ?>
    <? $this->load->view('custom-style'); ?>
</head>

<body>
    <? $this->load->view('navigation'); ?>

    <section id="collection-list">
        <? foreach ($arr_collection as $collection): ?>
            <a href="<?= base_url(); ?>product/filter/1/newest/<?= $collection->id; ?>/0/0/0/0#all-product-wrapper">
                <div class="collection-thumbnail">
                    <div class="content-inside" style="background-image:url(<?= $setting->setting__system_admin_url; ?>images/website/<?= $collection->image_name; ?>)"></div>
                    <div class="white-overlay">
                        <div class="black-gradient-overlay">
                            <div class="collection-thumbnail-inner">
                                <h2 class="section-title"><?= $collection->name; ?></h2>
                                <p><?= $collection->description; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        <? endforeach; ?>
    </section>

    <? $this->load->view('footer'); ?>

</body>

<? $this->load->view('js'); ?>


</html>
