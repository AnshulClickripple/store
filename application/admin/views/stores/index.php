<?php include(ADMIN_INCLUDE_PATH . '/header.php'); ?>
<?php include(ADMIN_INCLUDE_PATH . '/sidebar.php'); ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <h1><?= $this->lang->line('stores') ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-0">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="<?= DASHBOARD_PATH ?>"><?= $this->lang->line('dashboard') ?></a></li>
                                <li><a href="<?= STORES_PATH ?>"><?= $this->lang->line('store_list') ?></a></li>
                                <!--	<li class="active">Data Table</li>-->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content">

                <?php if (isset($success_message) && $success_message != '') {  ?>

                    <div class="alert alert-info alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?= $this->lang->line('success') ?>!</strong> <?php echo isset($success_message) ? $success_message : $this->session->flashdata('invalid'); ?>
                    </div>

                <?php  } ?>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card alert">

                            <div class="pull-right">
                                <a class="btn btn-success btn-flat m-b-10 m-l-5" style="margin-right:15px!important" href="<?= STORES_PATH ?>/add"><?= $this->lang->line('add_store') ?></a>
                                <input class="btn btn-danger btn-flat m-b-10 m-l-5" type="submit" onclick="multiple_delete('<?= STORES_PATH ?>/multiple_delete')" id="postme" value="Delete" disabled="disabled">


                            </div>


                            <div class="bootstrap-data-table-panel">
                                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">

                                    <thead>
                                        <tr>
                                            <th><input type='checkbox' name='select_all' id='select_all' value='' /></th>

                                            <th><?= $this->lang->line('id') ?></th>
                                            <th><?= $this->lang->line('owner') ?></th>
                                            <th><?= $this->lang->line('title') ?></th>
                                            <th><?= $this->lang->line('email_id') ?></th>
                                            <th><?= $this->lang->line('phone_number') ?></th>
                                            <th><?= $this->lang->line('address') ?></th>
                                            <th><?= $this->lang->line('registration_date') ?></th>
                                            <th width="100px"><?= $this->lang->line('action') ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($results)) {

                                            $html = '';

                                            foreach ($results as $single) { ?>
                                                <tr>
                                                    <td><input type='checkbox' name='checked_id' id='checkbox1' class='checkbox' value='<?= $single['id'] ?>' /></td>
                                                    <td><?= $single['id'] ?></td>
                                                    <td><?= urldecode($single['first_name']) . ' ' . urldecode($single['last_name']) ?></td>
                                                    <td><?= urldecode($single['name']) ?></td>
                                                    <td><?= urldecode($single['email']) ?></td>
                                                    <td><?= $single['phone'] ?></td>
                                                    <td><?= urldecode($single['address']) . '<br>' . urldecode($single['city_name']) . ', ' . urldecode($single['state_name']) . '<br>' . urldecode($single['country_name']) . '-' . $single['pincode'] ?> </td>
                                                    <td><?= date('d-m-Y', strtotime($single['created'])) ?></td>
                                                    <td>&nbsp;&nbsp;<a class="fa fa-eye" data-toggle="tooltip" style="color: #00c0ef;" title="<?= $this->lang->line('view') ?>!" href="<?= STORES_PATH ?>/view/<?= $single['id'] ?>"></a>&nbsp;&nbsp;<a class="ti-pencil-alt" data-toggle="tooltip" style="color: #00c0ef;" title="<?= $this->lang->line('edit') ?>!" href="<?= STORES_PATH ?>/edit/<?= $single['id'] ?>"></a>&nbsp;&nbsp;
                                                        <a class="fa fa-plus" data-toggle="tooltip" style="color: #00c0ef;" title="<?= $this->lang->line('add_subcategory') ?>!" href="<?= SUBCATEGORY_PATH ?>/add/<?= $single['id'] ?>"></a>&nbsp;&nbsp;
                                                        <a href="javascript:void(0)" class="ti-trash" style="color:red" data-toggle="tooltip" title="<?= $this->lang->line('delete') ?>!" onclick="delete_status('<?= STORES_PATH ?>/delete', '<?= $single['id'] ?>')"></a>&nbsp;&nbsp;
                                                        <a href="<?= STORES_PATH ?>/invoice/<?= $single['id'] ?>" class="fa fa-file" style="color:green" data-toggle="tooltip" title="<?= $this->lang->line('view_invoice') ?>"></a></td>
                                                </tr>
                                        <?php

                                            }
                                        }
                                        ?>




                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /# card -->
                    </div><!-- /# column -->
                </div><!-- /# row -->
            </div><!-- /# main content -->
        </div><!-- /# container-fluid -->
    </div><!-- /# main -->
</div><!-- /# content wrap -->

<?php include(ADMIN_INCLUDE_PATH . '/footer.php');
include(ADMIN_INCLUDE_PATH . '/close.php'); ?>
